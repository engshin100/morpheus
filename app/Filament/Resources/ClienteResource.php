<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Cliente;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ClienteResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ClienteResource\RelationManagers;

class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make()->schema([
                    Section::make('Dados Pessoais')
                    ->icon('heroicon-s-user-plus')
                    ->description('Adicionar dados pessoais do cliente')
                    ->schema([
                            TextInput::make('nome')
                                ->label('Nome')
                                ->placeholder('Nome completo'),
                            Group::make([
                                TextInput::make('cpf')
                                ->label('CPF/MF')
                                ->mask('999.999.999-99')
                                    ->placeholder('000.000.00-00'),
                                DatePicker::make('data_nascimento')
                                    ->minDate(now()->subYear(100))
                                    ->maxDate(now()),
                            ])->columns(2),
                            Group::make([
                                TextInput::make('rg')->placeholder('0000000-SSP/RN'),
                                DatePicker::make('rg_exp')->label('Exp. Rg')
                                    ->maxDate(now())
                                    ->default(now()),
                            ])->columns(2),
                            TextInput::make('naturalidade')
                                ->placeholder('Naturalidade'),
                            TextInput::make('genitora')
                                ->placeholder('Nome da mãe'),
                            TextInput::make('genitor')
                                ->placeholder('Nome do pai'),
                            Select::make('sexo')->label('Sexo')
                                ->options([
                                    'MASCULINO (CISGÊNERO)' => 'Masculino (Cisgênego)',
                                    'FEMININO (CISGÊNERO)' => 'Feminino (Cisgênenro)',
                                    'OUTRA ORIENTAÇÃO DE GÊNERO (LGBTQI+)' => 'Outra orientação de gênero (LGBTQI+)',
                                ]),
                            Select::make('estado_civil')->label('Estado Civil')->options([
                                'CASADO (A)' => 'Casado (a)',
                                'DESQUITADO (A)' => 'Desquitado (a)',
                                'DIVORCIADO (A)' => 'Divorciado (a)',
                                'SEPARADO (A)' => 'Separado (a)',
                                'FALECIDO (A)' => 'Falecido (a)',
                                'UNIÃO ESTÁVEL' => 'União estável',
                                'UNIÃO ESTÁVEL C/ MESMO SEXO' => 'União estável c/ mesmo sexo',
                                'Não informado' => 'Não informado'
                            ])
                        ])->columns(2)
                        ->collapsible(),
                    Section::make('Dados Bancários')->description('Dados bancárias do cliente')
                        ->icon('heroicon-s-building-library')
                        ->schema([
                            Forms\Components\Repeater::make('bancaria')
                            ->relationship()
                                ->schema([
                                Group::make([
                                    TextInput::make('codigo')
                                        ->label('Código')
                                        ->placeholder('000')->columnSpan(['xl'=>1]),
                                    TextInput::make('banco')
                                        ->label('Nome do banco')
                                        ->placeholder('Ex.: Banco do Bavária')
                                        ->columnSpan(['xl'=>3]),
                                    TextInput::make('conta')
                                        ->label('Conta nº')
                                        ->placeholder('Ex.: Banco do Bavária')
                                        ->columnSpan(['xl'=>1]),
                                ])->columns(5),
                                Group::make([
                                    TextInput::make('agencia')
                                    ->label('Agência')->placeholder('00000-**'),
                                    TextInput::make('tipo')->label('Tipo')
                                    ->placeholder('Ex.: Conta corrente'),
                                    TextInput::make('operacao')->label('Código operação')
                                    ->placeholder('Código operação')
                                    ->default('Não se aplica'),
                                ])->columns(3),
                            ])
                        ])
                        ->collapsible()
                        ->collapsed(),
                    Section::make('Dados Residenciais')->description('Dados residenciais do cliente')
                        ->icon('heroicon-s-envelope')
                        ->schema([
                            Forms\Components\Repeater::make('residencial')
                            ->relationship()
                            ->schema([
                                Group::make([
                                    TextInput::make('cep')->label('CEP')
                                        ->mask('99999-999')
                                        ->columnSpan(['xl'=>1]),
                                    TextInput::make('logradouro')
                                        ->label('Logradouro')
                                        ->columnSpan(['xl'=>2]),
                                        TextInput::make('complemento')
                                        ->label('Complemento')
                                        ->columnSpan(['xl'=>2]),
                                ])->columns(5),
                                Group::make([
                                    TextInput::make('bairro')->columnSpan(['xl' => 2]),
                                    TextInput::make('localidade')->columnSpan(2),
                                    TextInput::make('uf')->columnSpan(['xl' => 1]),
                                ])->columns(5),
                            ])
                        ])
                        ->collapsible()
                        ->collapsed(),
                    Section::make('Documentos')
                        ->icon('heroicon-s-cloud-arrow-up')
                        ->description('Enviar arquivos')->schema([
                            Forms\Components\Repeater::make('arquivos')
                            ->relationship()
                            ->schema([
                                Forms\Components\FileUpload::make('arquivo')
                                    ->multiple()
                                    ->panelLayout('grid')
                                    ->openable()
                                    ->downloadable()
                                    ->label('Envie um ou mais Arquivos'),
                            ])
                        ])
                        ->collapsed()
                        ->collapsible(),
                        Forms\Components\Hidden::make('user_id')->default(auth()->id())
                        ])
                    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome'),
                Tables\Columns\TextColumn::make('cpf'),
                Tables\Columns\TextColumn::make('data_nascimento')->label('Data nascimento')
                    ->date('d/m/Y'),
                Tables\Columns\TextColumn::make('rg')->label('RG'),
                Tables\Columns\TextColumn::make('rg_exp')->label('Data Exp.'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListClientes::route('/'),
            'create' => Pages\CreateCliente::route('/create'),
            'edit' => Pages\EditCliente::route('/{record}/edit'),
        ];
    }
}
