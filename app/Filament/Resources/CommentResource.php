<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('post_id')
                    ->label('Пост')
                    ->relationship('post', 'title')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->disabled(fn ($livewire) => $livewire instanceof Pages\EditComment)
                    ->dehydrated(fn ($livewire) => !($livewire instanceof Pages\EditComment) || $livewire->record->post_id !== null),

                Forms\Components\RichEditor::make('content')
                    ->label('Content')
                    ->required()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'link',
                        'blockquote',
                        'bulletList',
                        'orderedList',
                        'h2',
                        'h3',
                        'redo',
                        'undo',
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->sortable()
                    ->dateTime(),

                Tables\Columns\TextColumn::make('post.title')
                    ->label('Post')
                    ->searchable(),

                Tables\Columns\TextColumn::make('content')
                    ->html()
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        return strip_tags($column->getState());
                    })
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('От'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('До'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'С: ' . $data['created_from'];
                        }

                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'По: ' . $data['created_until'];
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
