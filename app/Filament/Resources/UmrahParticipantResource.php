<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UmrahParticipantResource\Pages;
use App\Filament\Resources\UmrahParticipantResource\RelationManagers;
use App\Models\UmrahParticipant;
use App\Models\UmrahDatabase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Laravel\SerializableClosure\Serializers\Native;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class UmrahParticipantResource extends Resource
{
    protected static ?string $model = UmrahParticipant::class;
    protected static bool $shouldRegisterNavigation = false;

    public static function getModelLabel(): string
    {
        return __('umrah_participant.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('umrah_participant.plural_model_label');
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3) // Create a 2-column grid
                    ->schema([
                        // Column 1: Participant Picture
                        Forms\Components\Section::make(__('umrah_participant.sections.participant_picture'))
                        ->description(__('umrah_participant.descriptions.upload_picture'))
                            ->schema([
                                Forms\Components\FileUpload::make('picture')
                                    ->label(__('umrah_participant.labels.picture'))
                                    ->image()
                                    ->maxSize(2048)
                                    ->rules(['image', 'mimes:jpg,jpeg,png', 'max:2048'])
                                    ->imagePreviewHeight('310') // Set a larger height for the preview
                                    ->imageResizeTargetWidth('300') // Set a smaller width for portrait dimensions
                                    ->imageResizeTargetHeight('810') // Keep the height for portrait dimensions
                                    ->openable(), // Enable larger view in a modal window
                            ])
                            ->columnSpan(1), // Occupy 1 column

                        // Column 2: Participant Code (Organized in rows)
                        Forms\Components\Section::make(__('umrah_participant.sections.participant_code'))
                        ->description(__('umrah_participant.descriptions.unique_code'))
                            ->schema([
                                // Row: File No., Registration No., and No.
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\Hidden::make('umrah_database_id'),
                                        Forms\Components\TextInput::make('file_no')
                                            ->label(__('umrah_participant.labels.file_no'))
                                            ->placeholder(__('umrah_participant.placeholders.file_no')),
                                            Forms\Components\TextInput::make('registration_no')
                                                ->label(__('umrah_participant.labels.registration_no'))
                                                ->disabled() // Always disabled by default
                                                ->reactive()
                                                ->placeholder(__('umrah_participant.placeholders.registration_no'))
                                                ->suffixAction(
                                                    Forms\Components\Actions\Action::make('edit_registration_no')
                                                        ->label(__('umrah_participant.labels.edit'))
                                                        ->icon('heroicon-m-pencil-square')
                                                        ->action(fn (Forms\Get $get, Forms\Set $set) => $set('is_editing_registration_no', !$get('is_editing_registration_no')))
                                                )
                                                ->visible(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord) // Show field in both create & edit, but suffix button only in edit
                                                ->disabled(fn ($get, $livewire) => !$get('is_editing_registration_no') || $livewire instanceof \Filament\Resources\Pages\CreateRecord), // Enable only if toggled and in edit mode
                                            Forms\Components\TextInput::make('no')
                                            ->label(__('umrah_participant.labels.no'))
                                            ->numeric()
                                            ->disabled() // Always disabled by default
                                            ->reactive()
                                            ->suffixAction(
                                                Forms\Components\Actions\Action::make('edit_no')
                                                    ->label(__('umrah_participant.labels.edit'))
                                                    ->icon('heroicon-m-pencil-square')
                                                    ->action(fn (Forms\Get $get, Forms\Set $set) => $set('is_editing_no', !$get('is_editing_no')))
                                            )
                                            ->visible(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord) // Show field in both create & edit, but suffix button only in edit
                                            ->disabled(fn ($get, $livewire) => !$get('is_editing_no') || $livewire instanceof \Filament\Resources\Pages\CreateRecord), // Enable only if toggled and in edit mode
                                    ]),

                                // Row: Group Code and Status
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('group_code')
                                            ->label(__('umrah_participant.labels.group_code'))
                                            ->placeholder(__('umrah_participant.placeholders.group_code')),
                                        Forms\Components\Select::make('status')
                                            ->label(__('umrah_participant.labels.status'))
                                            ->options([
                                                'Rayuan' => __('umrah_participant.status_options.appeal'),
                                                'Rayuan Khas' => __('umrah_participant.status_options.special_appeal'),
                                                'Terpilih' => __('umrah_participant.status_options.selected'),
                                                'Terpilih Lewat' => __('umrah_participant.status_options.late_selected'),
                                                'Batal' => __('umrah_participant.status_options.cancelled'),
                                            ])
                                            ->native(false),
                                    ]),

                                // Row: Registration Date and Time
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\DatePicker::make('registration_date')
                                            ->label(__('umrah_participant.labels.registration_date'))
                                            ->displayFormat('d/m/Y') // Display as DD/MM/YYYY
                                            ->native(false) // Use Filament's custom picker instead of browser default
                                            ->suffixIcon('heroicon-o-calendar') // Adds clock icon beside input
                                            ->default(now())
                                            ->placeholder(__('umrah_participant.placeholders.registration_date')),
                                            //->required(), // Make it required
                                        Forms\Components\TimePicker::make('registration_time')
                                            ->label(__('umrah_participant.labels.registration_time'))
                                            ->displayFormat('H:i') // 24-hour format (HH:mm)
                                            ->seconds(false)
                                            ->seconds(false) // Hide seconds to keep it clean
                                            ->suffixIcon('heroicon-o-clock')
                                            ->default(now()), // Default to current time
                                            //->required(), // Make it required
                                    ]),

                                // Row: Package, Package Code, and Room
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\Select::make('package')
                                            ->label(__('umrah_participant.labels.package'))
                                            ->options([
                                                'NUHASI' => 'NUHASI',
                                                'BRUNZI' => 'BRUNZI',
                                                'FIDDI' => 'FIDDI',
                                                'ZAHABI' => 'ZAHABI',
                                            ])
                                            ->native(false),
                                        Forms\Components\TextInput::make('package_code')
                                            ->label(__('umrah_participant.labels.package_code'))
                                            ->placeholder(__('umrah_participant.placeholders.package_code')),
                                        Forms\Components\Select::make('room_type')
                                            ->label(__('umrah_participant.labels.room_type'))
                                            ->options([
                                                'SINGLE' => __('umrah_participant.room_options.single'),
                                                'DOUBLE' => __('umrah_participant.room_options.double'),
                                                'TRIPLE' => __('umrah_participant.room_options.triple'),
                                                'QUAD' => __('umrah_participant.room_options.quadruple'),
                                                'QUINT' => __('umrah_participant.room_options.quintuple'),
                                            ])
                                            ->native(false),
                                    ]),
                            ])
                            ->columnSpan(2),
                    ]),

                    //SECTION PESERTA HAJI
                    Forms\Components\Section::make(__('umrah_participant.sections.participant_info'))
                    ->description(__('umrah_participant.descriptions.participant_info'))
                    ->schema([
                        Forms\Components\Grid::make(1) // Overall grid for alignment
                            ->schema([
                                // Row 1: Name
                                Forms\Components\TextInput::make('name')
                                    ->label(__('umrah_participant.labels.name'))
                                    ->placeholder(__('umrah_participant.placeholders.name')),
                
                                // Row 2: IC No, Passport No, Age
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\TextInput::make('ic_no')
                                            ->label(__('umrah_participant.labels.ic_no'))
                                            ->numeric()
                                            ->placeholder(__('umrah_participant.placeholders.ic_no'))
                                            ->live(onBlur: true) // Ensures live update
                                            ->afterStateUpdated(function (Get $get, Set $set) {
                                                self::calculateAge($get, $set); // Updates age
                                            }),
                                        Forms\Components\TextInput::make('passport_no')
                                            ->label(__('umrah_participant.labels.passport_no'))
                                            ->placeholder(__('umrah_participant.placeholders.passport_no')),
                                        Forms\Components\TextInput::make('age')
                                            ->label(__('umrah_participant.labels.age'))
                                            ->default(0) // Set default to 0
                                            ->formatStateUsing(fn ($state) => $state ?? 0) // Ensure '0' appears even if null
                                            ->placeholder(__('umrah_participant.placeholders.age'))
                                            ->readOnly(),
                                        
                                    ]),
                
                                // Row 3: Gender, Race, Religion
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\Select::make('gender')
                                            ->label(__('umrah_participant.labels.gender'))
                                            ->options([
                                                'Lelaki' => __('umrah_participant.gender_options.male'),
                                                'Perempuan' => __('umrah_participant.gender_options.female'),
                                            ])
                                            ->native(false)
                                            ->placeholder(__('umrah_participant.placeholders.gender')),
                                        Forms\Components\Select::make('race')
                                            ->label(__('umrah_participant.labels.race'))
                                            ->options([
                                                'Melayu' => __('umrah_participant.race_options.malay'),
                                                'Cina' => __('umrah_participant.race_options.chinese'),
                                                'India' => __('umrah_participant.race_options.indian'),
                                                'Lain-lain' => __('umrah_participant.race_options.other'),
                                            ])
                                            ->native(false)
                                            ->placeholder(__('umrah_participant.placeholders.race')),
                                        Forms\Components\TextInput::make('religion')
                                            ->label(__('umrah_participant.labels.religion'))
                                            ->default(__('umrah_participant.default_values.religion'))
                                            ->readOnly(),
                                    ]),
                
                                // Row 4: Marriage Status, Job, Job Sector
                                Forms\Components\Grid::make(3)
                                ->schema([
                                    Forms\Components\Select::make('marriage_status')
                                        ->label(__('umrah_participant.labels.marriage_status'))
                                        //->placeholder(__('umrah_participant.placeholders.marriage_status'))
                                        ->options([
                                            'Berkahwin' => __('umrah_participant.marital_options.married'),
                                            'Cerai' => __('umrah_participant.marital_options.divorced'),
                                            'Kematian Pasangan' => __('umrah_participant.marital_options.spouse_death'),
                                            'Bujang' => __('umrah_participant.marital_options.single'),
                                        ])
                                        ->native(false),
                                    Forms\Components\TextInput::make('job')
                                        ->label(__('umrah_participant.labels.job'))
                                        ->placeholder(__('umrah_participant.placeholders.job')),
                                    Forms\Components\Select::make('job_sector')
                                        ->label(__('umrah_participant.labels.job_sector'))
                                        //->placeholder(__('umrah_participant.placeholders.job_sector')),
                                        ->options([
                                            'Sektor Awam' => __('Sektor Awam'),
                                            'Sektor Swasta' => __('Sektor Swasta'),
                                            'FELDA' => __('FELDA'),
                                            'FGV' => __('FGV'),
                                            'Ahli Perniagaan' => __('Ahli Perniagaan'),
                                            'Bekerja Sendiri' => __('Bekerja Sendiri'),
                                            'Suri Rumah'=> __('Suri Rumah'),
                                            'Pesara FELDA'=> __('Pesara FELDA'),
                                            'Pesara'=> __('Pesara'),
                                            'Lain-lain'=> __('Lain-lain'),
                                        ])
                                        ->native(false),
                                ]),

                                // Row 5: Title, Phone, Email
                                Forms\Components\Grid::make(3)
                                ->schema([
                                    Forms\Components\TextInput::make('title')
                                        ->label(__('umrah_participant.labels.title'))
                                        ->placeholder(__('umrah_participant.placeholders.title')),
                                    Forms\Components\TextInput::make('phone')
                                        ->label(__('umrah_participant.labels.phone'))
                                        ->placeholder(__('umrah_participant.placeholders.phone'))
                                        ->tel(),
                                    Forms\Components\TextInput::make('email')
                                        ->label(__('umrah_participant.labels.email'))
                                       ->placeholder(__('umrah_participant.placeholders.email')),
                                ]),
                            ]),
                    ]),
                
                    //SECTION: ADDRESS RUMAH
                    Forms\Components\Section::make(__('umrah_participant.sections.address_info'))
                        ->description(__('umrah_participant.descriptions.address_info'))
                        ->schema([
                            Forms\Components\Grid::make(1)
                                ->schema([
                                    // Row 1: Address Lines
                                    Forms\Components\TextInput::make('address_1')
                                        ->label(__('umrah_participant.labels.address_1'))
                                        ->placeholder(__('umrah_participant.placeholders.address_1')),
                                    Forms\Components\TextInput::make('address_2')
                                        ->label(__('umrah_participant.labels.address_2'))
                                        ->placeholder(__('umrah_participant.placeholders.address_2')),
                                    Forms\Components\TextInput::make('address_3')
                                        ->label(__('umrah_participant.labels.address_3'))
                                        ->placeholder(__('umrah_participant.placeholders.address_3')),

                                    // Row 2: Postcode, District, State
                                    Forms\Components\Grid::make(3)
                                        ->schema([
                                            Forms\Components\TextInput::make('postcode')
                                                ->label(__('umrah_participant.labels.postcode'))
                                                ->placeholder(__('umrah_participant.placeholders.postcode'))
                                                ->numeric(),
                                            Forms\Components\TextInput::make('district')
                                                ->label(__('umrah_participant.labels.district'))
                                                ->placeholder(__('umrah_participant.placeholders.district')),
                                            Forms\Components\Select::make('state')
                                                ->label(__('umrah_participant.labels.state'))
                                                ->options([
                                                    'Johor' => 'Johor',
                                                    'Kedah' => 'Kedah',
                                                    'Kelantan' => 'Kelantan',
                                                    'Melaka' => 'Melaka',
                                                    'Negeri Sembilan' => 'Negeri Sembilan',
                                                    'Pahang' => 'Pahang',
                                                    'Perak' => 'Perak',
                                                    'Perlis' => 'Perlis',
                                                    'Pulau Pinang' => 'Pulau Pinang',
                                                    'Sabah' => 'Sabah',
                                                    'Sarawak' => 'Sarawak',
                                                    'Selangor' => 'Selangor',
                                                    'Terengganu' => 'Terengganu',
                                                    'Kuala Lumpur' => 'Kuala Lumpur',
                                                    'Labuan' => 'Labuan',
                                                    'Putrajaya' => 'Putrajaya',
                                                ])
                                                ->searchable()
                                                ->preload(),
                                        ]),
                                ]),
                        ]),
                
                    // SECTION 4: PARTICIPANTS WARIS
                    Forms\Components\Section::make(__('umrah_participant.sections.participant_waris'))
                    ->description(__('umrah_participant.descriptions.participant_waris'))
                    ->schema([
                        Forms\Components\Repeater::make('waris')
                            ->schema([
                                // Waris Name
                                Forms\Components\TextInput::make('nama_waris')
                                    ->label(__('umrah_participant.labels.nama_waris'))
                                    ->placeholder(__('umrah_participant.placeholders.nama_waris')),

                                // Row: Relationship, Phone, Email
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\TextInput::make('hubungan_waris')
                                            ->label(__('umrah_participant.labels.hubungan_waris'))
                                            ->placeholder(__('umrah_participant.placeholders.hubungan_waris')),
                                        Forms\Components\TextInput::make('no_telefon_waris')
                                            ->label(__('umrah_participant.labels.no_telefon_waris'))
                                            ->placeholder(__('umrah_participant.placeholders.no_telefon_waris'))
                                            ->tel(),
                                        Forms\Components\TextInput::make('e-mel_waris')
                                            ->label(__('umrah_participant.labels.e-mel_waris'))
                                            ->placeholder(__('umrah_participant.placeholders.e-mel_waris'))
                                            ->email(),
                                    ]),

                                // Address Waris (Large Textarea)
                                Forms\Components\Textarea::make('alamat_waris')
                                    ->label(__('umrah_participant.labels.alamat_waris'))
                                    ->placeholder(__('umrah_participant.placeholders.alamat_waris'))
                                    ->rows(5),
                            ])
                            ->createItemButtonLabel(__('umrah_participant.buttons.tambah_waris'))
                    ]),                           
                

                // SECTION 5: Tabung Haji & Passport Details
                Forms\Components\Section::make(__('umrah_participant.sections.th_info'))
                ->description(__('umrah_participant.descriptions.th_info'))
                ->schema([
                    // Group Hajj Registration No. and TH Account No. in one row
                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\TextInput::make('hajj_registration_no')
                                ->label(__('umrah_participant.labels.hajj_registration_no'))
                                ->placeholder(__('umrah_participant.placeholders.hajj_registration_no')),
                            Forms\Components\TextInput::make('th_account_no')
                                ->label(__('umrah_participant.labels.th_account_no'))
                                ->placeholder(__('umrah_participant.placeholders.th_account_no')),
                        ]),

                    // Group Tahun Daftar Haji and Bulan Daftar Haji in one row
                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\Select::make('year_hajj_registration')
                                ->label(__('umrah_participant.labels.year_hajj_registration'))
                                ->options(array_combine(
                                    range(now()->year - 45, now()->year + 0),
                                    range(now()->year - 45, now()->year + 0)
                                ))
                                ->searchable(),
                            Forms\Components\Select::make('month_hajj_registration')
                                ->label(__('umrah_participant.labels.month_hajj_registration'))
                                ->options([
                                    'JAN'  => 'January',
                                    'FEB'  => 'February',
                                    'MAC'  => 'March',
                                    'APR'  => 'April',
                                    'MAY'  => 'May',
                                    'JUN'  => 'June',
                                    'JUL'  => 'July',
                                    'AUG'  => 'August',
                                    'SEP'  => 'September',
                                    'OCT' => 'October',
                                    'NOV' => 'November',
                                    'DEC' => 'December',
                                ])
                                ->searchable(),
                        ]),
                ]),

                // SECTION 6: Representative / Media Survey and Sizes
                Forms\Components\Section::make(__('umrah_participant.sections.representative_media_sizes'))
                ->description(__('umrah_participant.descriptions.representative_media_sizes'))
                ->schema([
                    // Row 1: Representative and Media Survey
                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\TextInput::make('representative')
                                ->label(__('umrah_participant.labels.representative'))
                                ->placeholder(__('umrah_participant.placeholders.representative')),
                            // Change Media Survey to a select option
                            Forms\Components\Select::make('media_survey')
                                ->label(__('umrah_participant.labels.media_survey'))
                                ->placeholder(__('umrah_participant.placeholders.media_survey'))
                                ->options([
                                    'Facebook' => 'Facebook',
                                    'Instagram'  => 'Instagram',
                                    'Google' => 'Google',
                                    'Website'=> 'Website',
                                    'Kursus Haji' => 'Kursus Haji',
                                    'RTM TV1'=> 'RTM TV1',
                                    'Ahli Keluarga / Rakan'=> 'Ahli Keluarga / Rakan',
                                    'Karnival Haji PHJ'=> 'Karnival Haji PHJ',
                                ])
                                ->searchable() // optional
                                ->native(false),
                        ]),

                    // Row 2: Shirt Size, Kurta Size, and Kopiah Size
                    Forms\Components\Grid::make(3)
                        ->schema([
                            // Shirt Size as a select
                            Forms\Components\Select::make('shirt_size')
                                ->label(__('umrah_participant.labels.shirt_size'))
                                ->placeholder(__('umrah_participant.placeholders.shirt_size'))
                                ->options([
                                    'XS' => 'XS',
                                    'S'  => 'S',
                                    'M'  => 'M',
                                    'L'  => 'L',
                                    'XL' => 'XL',
                                    'XXL'=> 'XXL',
                                ])
                                ->native(false),
                            // Kurta Size as a select
                            Forms\Components\Select::make('kurta_size')
                                ->label(__('umrah_participant.labels.kurta_size'))
                                ->placeholder(__('umrah_participant.placeholders.kurta_size'))
                                ->options([
                                    'XS' => 'XS',
                                    'S'  => 'S',
                                    'M'  => 'M',
                                    'L'  => 'L',
                                    'XL' => 'XL',
                                    'XXL'=> 'XXL',
                                ])
                                ->native(false),
                            // Kopiah Size as a select
                            Forms\Components\Select::make('kopiah_size')
                                ->label(__('umrah_participant.labels.kopiah_size'))
                                ->placeholder(__('umrah_participant.placeholders.kopiah_size'))
                                ->options([
                                    'small'  => 'Small',
                                    'medium' => 'Medium',
                                    'large'  => 'Large',
                                ])
                                ->native(false),
                        ]),
                    ]),

                // SECTION 7: Remarks
                Forms\Components\Section::make(__('umrah_participant.sections.remarks_section_title'))
                ->description(__('umrah_participant.descriptions.remarks_section_description'))
                ->schema([
                    Forms\Components\Textarea::make('remarks_1')
                        ->label(__('umrah_participant.labels.remarks_1_label'))
                        ->placeholder(__('umrah_participant.placeholders.remarks_1_placeholder'))
                        ->rows(5)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('remarks_2')
                        ->label(__('umrah_participant.labels.remarks_2_label'))
                        ->placeholder(__('umrah_participant.placeholders.remarks_2_placeholder'))
                        ->rows(5)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('remarks_3')
                        ->label(__('umrah_participant.labels.remarks_3_label'))
                        ->placeholder(__('umrah_participant.placeholders.remarks_3_placeholder'))
                        ->rows(5)
                        ->columnSpanFull(),
                ]),

                // SECTION 8: Accompanying Family Members
                Forms\Components\Section::make(__('umrah_participant.sections.family_details_section_title'))
                ->description(__('umrah_participant.descriptions.family_details_section_description'))
                ->schema([
                    Forms\Components\Repeater::make('family_member')
                        ->label(__('umrah_participant.labels.family_member_label'))
                        ->schema([
                            Forms\Components\Grid::make(3)
                                ->schema([
                                    Forms\Components\Select::make('family_member_name')
                                        ->label(__('umrah_participant.labels.family_member_name_label'))
                                        ->options(function ($get, $livewire) {
                                            $umrahDatabaseId = $livewire->parent->id ?? null;
                                            $currentParticipantId = $livewire->record?->id;
                                            
                                            $selectedNames = collect($get('../../family_member'))
                                                ->pluck('family_member_name')
                                                ->filter()
                                                ->toArray();
                                            
                                            $query = UmrahParticipant::where('umrah_database_id', $umrahDatabaseId);
                                            
                                            if ($currentParticipantId) {
                                                $query->where('id', '!=', $currentParticipantId);
                                            }
                                            
                                            if (!empty($selectedNames)) {
                                                $query->whereNotIn('name', $selectedNames);
                                            }
                                            
                                            return $query->pluck('name', 'name')->toArray();
                                        })
                                        ->reactive()
                                        ->searchable()
                                        ->native(false)
                                        ->afterStateUpdated(function ($state, $set) {
                                            $participant = UmrahParticipant::where('name', $state)->first();
                                            if ($participant) {
                                                $set('family_member_phone', $participant->phone);
                                            } else {
                                                $set('family_member_phone', '');
                                            }
                                        }),

                                    Forms\Components\TextInput::make('family_member_phone')
                                        ->label(__('umrah_participant.labels.family_member_phone_label'))
                                        ->default('')
                                        ->formatStateUsing(fn ($state) => $state ?? '')
                                        ->readOnly()
                                        ->dehydrated(),

                                    Forms\Components\TextInput::make('family_member_relationship')
                                        ->label(__('umrah_participant.labels.family_member_relationship_label'))
                                        ->placeholder(__('umrah_participant.placeholders.family_member_relationship_placeholder')),
                                ]),
                        ])
                        ->createItemButtonLabel(__('umrah_participant.buttons.tambah_keluarga'))
                ]),
                        
                // SECTION 9: Payment Details
                Forms\Components\Section::make(__('umrah_participant.sections.payment_details_section_title'))
                ->description(__('umrah_participant.descriptions.payment_details_section_description'))
                ->schema([
                    // Row 1: Package Price, Discount, Price After Discount
                    Forms\Components\Group::make()
                        ->schema([
                            Forms\Components\TextInput::make('package_price')
                                ->label(__('umrah_participant.labels.package_price'))
                                ->prefix('RM')
                                ->placeholder(__('umrah_participant.placeholders.package_price'))
                                ->numeric()
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    Self::CalculatePayment($get, $set);
                                }),
                            Forms\Components\TextInput::make('discount')
                                ->label(__('umrah_participant.labels.discount'))
                                ->prefix('RM')
                                ->placeholder(__('umrah_participant.placeholders.discount'))
                                ->numeric()
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    Self::CalculatePayment($get, $set);
                                }),
                            Forms\Components\TextInput::make('price_after_discount')
                                ->label(__('umrah_participant.labels.price_after_discount'))
                                ->prefix('RM')
                                ->default(0.00)
                                ->formatStateUsing(fn ($state) => number_format($state, 2, '.', ''))
                                ->placeholder(__('umrah_participant.placeholders.price_after_discount'))
                                ->readOnly()
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    Self::CalculatePayment($get, $set);
                                }),
                        ])
                        ->columns(3),

                    // Row 2: Wang Naik Haji, Upgrade Khemah Khas, Upgrade Lain-Lain
                    Forms\Components\Group::make()
                        ->schema([
                            /*Forms\Components\TextInput::make('wang_naik_haji')
                                ->label(__('umrah_participant.labels.wang_naik_haji'))
                                ->prefix('RM')
                                ->placeholder(__('umrah_participant.placeholders.wang_naik_haji'))
                                ->numeric()
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    Self::CalculatePayment($get, $set);
                                }),
                            Forms\Components\TextInput::make('upgrade_khemah_khas')
                                ->label(__('umrah_participant.labels.upgrade_khemah_khas'))
                                ->prefix('RM')
                                ->placeholder(__('umrah_participant.placeholders.upgrade_khemah_khas'))
                                ->numeric()
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    Self::CalculatePayment($get, $set);
                                }),*/
                            Forms\Components\TextInput::make('upgrade')
                                ->label(__('umrah_participant.labels.upgrade'))
                                ->prefix('RM')
                                ->placeholder(__('umrah_participant.placeholders.upgrade'))
                                ->numeric()
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    Self::CalculatePayment($get, $set);
                                }),
                        ])
                        ->columns(3),

                    // Row 3: Total (Spans full width)
                    Forms\Components\TextInput::make('total')
                        ->label(__('umrah_participant.labels.total'))
                        ->prefix('RM')
                        ->default(0.00)
                        ->formatStateUsing(fn ($state) => number_format($state, 2, '.', ''))
                        ->placeholder(__('umrah_participant.placeholders.total'))
                        ->readOnly()
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            Self::CalculatePayment($get, $set);
                        })
                        ->columnSpan('full'),

                    // Row 4: Payment Repeater (Spans full width)
                    Forms\Components\Repeater::make('payment_made')
                        ->label(__('umrah_participant.labels.payment_made'))
                        ->schema([
                            Forms\Components\TextInput::make('payment_amount')
                                ->label(__('umrah_participant.labels.payment_amount'))
                                ->prefix('RM')
                                ->placeholder(__('umrah_participant.placeholders.payment_amount'))
                                ->numeric()
                                ->live(onBlur: true),
                            Forms\Components\TextInput::make('receipt')
                                ->label(__('umrah_participant.labels.receipt'))
                                ->placeholder(__('umrah_participant.placeholders.receipt'))
                                ->suffixIcon('heroicon-o-receipt-percent'),
                        ])
                        ->createItemButtonLabel(__('umrah_participant.buttons.payment_made'))
                        ->columns(2)
                        ->columnSpan('full')
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, $set, $get) {
                            // Calculate the sum of all payment amounts
                            $sum = collect($state)->sum('payment_amount');
                            $set('total_payment', $sum);

                            // Update the payment_left after total_payment is set
                            $set('payment_left', $get('total') - $sum);
                        }),

                    // Row 5: Total Payment and Payment Left
                    Forms\Components\Group::make()
                        ->schema([
                            Forms\Components\TextInput::make('total_payment')
                                ->label(__('umrah_participant.labels.total_payment'))
                                ->default(0.00)
                                ->formatStateUsing(fn ($state) => number_format($state, 2, '.', ''))
                                ->prefix('RM')
                                ->placeholder(__('umrah_participant.placeholders.total_payment'))
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    Self::CalculatePayment($get, $set);
                                })
                                ->readOnly(),
                            Forms\Components\TextInput::make('payment_left')
                                ->label(__('umrah_participant.labels.payment_left'))
                                ->default(0.00)
                                ->formatStateUsing(fn ($state) => number_format($state, 2, '.', ''))
                                ->prefix('RM')
                                ->placeholder(__('umrah_participant.placeholders.payment_left'))
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    Self::CalculatePayment($get, $set);
                                })
                                ->readOnly(),
                        ])
                        ->columns(2),

                    // Row 6: Payment Remarks (Spans full width)
                    Forms\Components\Textarea::make('payment_remarks')
                        ->label(__('umrah_participant.labels.payment_remarks'))
                        ->rows(3)
                        ->placeholder(__('umrah_participant.placeholders.payment_remarks'))
                        ->columnSpan('full'),
                ])
                ->columns(1) // Overall section columns
            ]);
    }
    

    public static function calculateAge(Get $get, Set $set): void
    {
        $icNo = $get('ic_no');

        if (preg_match('/^(\d{2})(\d{2})(\d{2})/', $icNo, $matches)) {
            $year = intval($matches[1]);
            $month = intval($matches[2]);
            $day = intval($matches[3]);

            // Determine full birth year (assuming 1900-2099 range)
            $currentYear = date('Y');
            $fullYear = ($year > intval(date('y'))) ? (1900 + $year) : (2000 + $year);

            // Calculate age
            $birthDate = \Carbon\Carbon::create($fullYear, $month, $day);
            $age = $birthDate->age;

            $set('age', $age);
        } else {
            $set('age', 0); // Set age to 0 if IC format is incorrect
        }
    }

    public static function CalculatePayment(Get $get, Set $set): void
    {
        // Cast the values to float before performing arithmetic operations
        $packagePrice = (float) $get('package_price');
        $discount = (float) $get('discount');
        $wangNaikHaji = (float) $get('wang_naik_haji');
        $upgradeKhemahKhas = (float) $get('upgrade_khemah_khas');
        $upgrade = (float) $get('upgrade');
        $totalPayment = (float) $get('total_payment');

        // Calculate price after discount
        $priceAfterDiscount = $packagePrice - $discount;
        $set('price_after_discount', $priceAfterDiscount);

        // Calculate total
        $total = ($priceAfterDiscount - $wangNaikHaji) + $upgradeKhemahKhas + $upgrade;
        $set('total', $total);

        // Calculate payment left
        $paymentLeft = $total - $totalPayment;
        $set('payment_left', $paymentLeft);
    }

    /*public static function CalculatePriceAfterDiscounts(Get $get, Set $set):void
    {
        $set('price_after_discount', $get('package_price') - $get('discount'));
    }
    
    public static function CalculateTotal(Get $get, Set $set):void
    {
        $set('total', ($get('price_after_discount') - $get('wang_naik_haji')) + $get('upgrade_khemah_khas') + $get('upgrade'));
    }

    public static function CalculatePaymentLeft(Get $get, Set $set):void
    {
        $set('payment_left', $get('total') - $get('total_payment'));
    }*/


    public static string $parentResource = UmrahDatabaseResource::class;

    public static function getRecordTitle(?Model $record): string|null|Htmlable
    {
        return $record?->name;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Participant Code
                Tables\Columns\TextColumn::make('file_no')
                    ->label(__('umrah_participant.table_labels.file_no'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('registration_no')
                    ->label(__('umrah_participant.table_labels.registration_no'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('no')
                    ->label(__('umrah_participant.table_labels.no'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('group_code')
                    ->label(__('umrah_participant.table_labels.group_code'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('umrah_participant.table_labels.status'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('registration_date')
                    ->label(__('umrah_participant.table_labels.registration_date'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('registration_time')
                    ->label(__('umrah_participant.table_labels.registration_time'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('package')
                    ->label(__('umrah_participant.table_labels.package'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('package_code')
                    ->label(__('umrah_participant.table_labels.package_code'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('room_type')
                    ->label(__('umrah_participant.table_labels.room_type'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),

                // Participant Details
                Tables\Columns\TextColumn::make('name')
                    ->label(__('umrah_participant.table_labels.name'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('ic_no')
                    ->label(__('umrah_participant.table_labels.ic_no'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('passport_no')
                    ->label(__('umrah_participant.table_labels.passport_no'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('age')
                    ->label(__('umrah_participant.table_labels.age'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('gender')
                    ->label(__('umrah_participant.table_labels.gender'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('race')
                    ->label(__('umrah_participant.table_labels.race'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('religion')
                    ->label(__('umrah_participant.table_labels.religion'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('marriage_status')
                    ->label(__('umrah_participant.table_labels.marriage_status'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('job')
                    ->label(__('umrah_participant.table_labels.job'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('job_sector')
                    ->label(__('umrah_participant.table_labels.job_sector'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('umrah_participant.table_labels.title'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('umrah_participant.table_labels.phone'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('umrah_participant.table_labels.email'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),

                // Participant Address
                Tables\Columns\TextColumn::make('address_1')
                    ->label(__('umrah_participant.table_labels.address_1'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('address_2')
                    ->label(__('umrah_participant.table_labels.address_2'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('address_3')
                    ->label(__('umrah_participant.table_labels.address_3'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('postcode')
                    ->label(__('umrah_participant.table_labels.postcode'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('district')
                    ->label(__('umrah_participant.table_labels.district'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('state')
                    ->label(__('umrah_participant.table_labels.state'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),

                // Tabung Haji Participant
                Tables\Columns\TextColumn::make('hajj_registration_no')
                    ->label(__('umrah_participant.table_labels.hajj_registration_no'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('th_account_no')
                    ->label(__('umrah_participant.table_labels.th_account_no'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('month_hajj_registration')
                    ->label(__('umrah_participant.table_labels.month_hajj_registration'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('year_hajj_registration')
                    ->label(__('umrah_participant.table_labels.year_hajj_registration'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),

                // Wakil, Media Survey, Clothing Size
                Tables\Columns\TextColumn::make('representative')
                    ->label(__('umrah_participant.table_labels.representative'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('media_survey')
                    ->label(__('umrah_participant.table_labels.media_survey'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('shirt_size')
                    ->label(__('umrah_participant.table_labels.shirt_size'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('kurta_size')
                    ->label(__('umrah_participant.table_labels.kurta_size'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('kopiah_size')
                    ->label(__('umrah_participant.table_labels.kopiah_size'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),

                // Participant Remarks
                Tables\Columns\TextColumn::make('remarks_1')
                    ->label(__('umrah_participant.table_labels.remarks_1'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('remarks_2')
                    ->label(__('umrah_participant.table_labels.remarks_2'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('remarks_3')
                    ->label(__('umrah_participant.table_labels.remarks_3'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),

                // Created at/ Updated at
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(fn (Pages\ListUmrahParticipants $livewire, Model $record): string => static::$parentResource::getUrl('umrah-participants.edit', [
                        'record' => $record,
                        'parent' => $livewire->parent,
                    ])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    /*public static function getPages(): array
    {
        return [
            'index' => Pages\ListUmrahParticipants::route('/'),
            'create' => Pages\CreateUmrahParticipant::route('/create'),
            'edit' => Pages\EditUmrahParticipant::route('/{record}/edit'),
        ];
    }*/
}
