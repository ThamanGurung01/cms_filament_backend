<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use UnitEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class HomepageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationLabel = 'Homepage Settings';
    protected static string|UnitEnum|null $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.homepage-settings';

    /**
     * Only superadmins can access Homepage Settings.
     */
    public static function canAccess(): bool
    {
        return auth()->user()?->isSuperAdmin() ?? false;
    }

    public function getMaxContentWidth(): \Filament\Support\Enums\Width|string|null
    {
        return \Filament\Support\Enums\Width::Full;
    }

    // Hero Section
    public ?string $home_hero_video_url = '';
    public ?string $home_hero_status_text = '';
    public ?string $home_hero_subtitle = '';
    public ?string $home_hero_title_line1 = '';
    public ?string $home_hero_title_line2 = '';
    public ?string $home_hero_description = '';
    public ?string $home_hero_btn1_label = '';
    public ?string $home_hero_btn1_video_url = '';
    public ?string $home_hero_btn2_label = '';
    public ?string $home_hero_btn2_url = '';
    public ?string $home_hero_btn1_type = 'video';
    public ?string $home_hero_btn1_video_source = 'url';
    public ?string $home_hero_btn1_video_file = '';
    public ?string $home_hero_btn2_type = 'link';
    public ?string $home_hero_btn2_video_source = 'url';
    public ?string $home_hero_btn2_video_file = '';
    public ?string $home_hero_btn2_video_url = '';

    // About Section (Two Column after Hero)
    public ?string $home_about_subtitle = 'Who We Are';
    public ?string $home_about_title = 'Nepal Film Production';
    public ?string $home_about_styled_title = 'Our Story';
    public ?string $home_about_description = 'We are a premier production house based in the heart of Nepal, delivering world-class film and media production services. With a passionate team of creatives, cutting-edge equipment, and breathtaking locations, we bring stories to life that captivate audiences worldwide.';
    public array|string|null $home_about_image = null;
    public ?string $home_about_image_alt = 'Nepal Film Production team at work';
    public ?string $home_about_btn_label = 'Learn More';
    public ?string $home_about_btn_url = '/about';

    // Section Headers
    public ?string $home_brands_subtitle = '';
    public ?string $home_brands_title = '';
    public ?string $home_brands_description = '';
    public ?string $home_showreel_subtitle = '';
    public ?string $home_showreel_title = '';
    public ?string $home_showreel_description = '';
    public ?string $home_showreel_video_url = '';
    public ?string $home_showreel_2_subtitle = '';
    public ?string $home_showreel_2_title = '';
    public ?string $home_showreel_2_description = '';
    public ?string $home_showreel_2_video_url = '';
    public ?string $home_showreel_3_subtitle = '';
    public ?string $home_showreel_3_title = '';
    public ?string $home_showreel_3_description = '';
    public ?string $home_showreel_3_video_url = '';
    public ?string $home_services_subtitle = '';
    public ?string $home_services_title = '';
    public ?string $home_services_description = '';
    public ?string $home_services_cta_label = '';
    public ?string $home_services_cta_url = '';
    public ?string $home_portfolio_subtitle = '';
    public ?string $home_portfolio_title = '';
    public ?string $home_portfolio_description = '';
    public ?string $home_stats_subtitle = '';
    public ?string $home_stats_title = '';
    public ?string $home_stats_description = '';
    public ?string $home_testimonials_subtitle = '';
    public ?string $home_testimonials_title = '';
    public ?string $home_testimonials_description = '';
    public ?string $home_blog_subtitle = '';
    public ?string $home_blog_title = '';
    public ?string $home_blog_description = '';
    public ?string $home_brands_styled_title = '';
    public ?string $home_showreel_styled_title = '';
    public ?string $home_showreel_2_styled_title = '';
    public ?string $home_showreel_3_styled_title = '';
    public ?string $home_services_styled_title = '';
    public ?string $home_portfolio_styled_title = '';
    public ?string $home_stats_styled_title = '';
    public ?string $home_testimonials_styled_title = '';
    public ?string $home_blog_styled_title = '';

    // Spotlight (Moved)
    public ?string $spotlight_title = '';
    public ?string $spotlight_subtitle = '';
    public ?string $spotlight_description = '';
    public ?string $spotlight_video_url = '';
    public ?string $spotlight_badge_label = '';
    public ?string $spotlight_highlight_1_icon = '';
    public ?string $spotlight_highlight_1_title = '';
    public ?string $spotlight_highlight_1_sub = '';
    public ?string $spotlight_highlight_2_icon = '';
    public ?string $spotlight_highlight_2_title = '';
    public ?string $spotlight_highlight_2_sub = '';
    public ?string $spotlight_cta_label = '';
    public ?string $spotlight_cta2_label = '';
    public ?string $spotlight_cta2_url = '';
    public ?string $spotlight_styled_title = '';
    public ?string $spotlight_title_suffix = '';
    public ?string $spotlight_video_source = 'url';
    public ?string $spotlight_video_file = '';

    // Stats (Moved)
    public ?string $stat_projects = '200';
    public ?string $stat_awards = '15';
    public ?string $stat_years = '10';
    public ?string $stat_partners = '50';

    // Blog
    public ?string $home_blog_count = '3';
    public ?string $home_blog_btn_label = '';

    // International Support Section
    public ?string $home_support_subtitle = '';
    public ?string $home_support_title = 'International Film Production';
    public ?string $home_support_styled_title = 'Support in Nepal';
    public ?string $home_support_c1_title = 'Production Support for USA Crews';
    public ?string $home_support_c1_desc = 'We support international teams with top US film productions, delivering documentary production in Nepal and commercial post production abroad, plus US permits, location management and fixer support.';
    public ?string $home_support_c1_icon = 'flag';
    public array|string|null $home_support_c1_image = null;
    public ?string $home_support_c1_image_alt = '';
    public ?string $home_support_c2_title = 'Support For European, Australian & Asian Teams';
    public ?string $home_support_c2_desc = 'Nepal Film Production partners with European, Australian and Asian teams to support international shoots in Nepal, offering Kathmandu location scouting, fixer services, crew and full logistics for safe, organized filming.';
    public ?string $home_support_c2_icon = 'public';
    public array|string|null $home_support_c2_image = null;
    public ?string $home_support_c2_image_alt = '';
    public ?string $home_support_c3_title = 'UK Film & Broadcast Production Managements';
    public ?string $home_support_c3_desc = 'We collaborate with the best Film production company in UK to deliver complete end to end Line Production in UK services. We make UK film projects in Nepal efficient, reliable and production ready.';
    public ?string $home_support_c3_icon = 'movie';
    public array|string|null $home_support_c3_image = null;
    public ?string $home_support_c3_image_alt = '';
    public ?string $home_support_c4_title = 'Production Partner From Kathmandu-Himalayas';
    public ?string $home_support_c4_desc = 'Nepal Film Production is a trusted, government registered film production company in Nepal, supporting international shoots from city locations to extreme Himalayan expeditions. Services include fixing, logistics, high altitude support and full production management.';
    public ?string $home_support_c4_icon = 'landscape';
    public array|string|null $home_support_c4_image = null;
    public ?string $home_support_c4_image_alt = '';

    public function mount(): void
    {
        $settings = Setting::map();

        $this->fill([
            'home_hero_video_url' => $settings['home_hero_video_url'] ?? '',
            'home_hero_status_text' => $settings['home_hero_status_text'] ?? '',
            'home_hero_subtitle' => $settings['home_hero_subtitle'] ?? '',
            'home_hero_title_line1' => $settings['home_hero_title_line1'] ?? '',
            'home_hero_title_line2' => $settings['home_hero_title_line2'] ?? '',
            'home_hero_description' => $settings['home_hero_description'] ?? '',
            'home_hero_btn1_label' => $settings['home_hero_btn1_label'] ?? '',
            'home_hero_btn1_video_url' => $settings['home_hero_btn1_video_url'] ?? '',
            'home_hero_btn2_label' => $settings['home_hero_btn2_label'] ?? '',
            'home_hero_btn2_url' => $settings['home_hero_btn2_url'] ?? '',
            'home_hero_btn1_type' => $settings['home_hero_btn1_type'] ?? 'video',
            'home_hero_btn1_video_source' => $settings['home_hero_btn1_video_source'] ?? 'url',
            'home_hero_btn1_video_file' => $settings['home_hero_btn1_video_file'] ?? '',
            'home_hero_btn2_type' => $settings['home_hero_btn2_type'] ?? 'link',
            'home_hero_btn2_video_source' => $settings['home_hero_btn2_video_source'] ?? 'url',
            'home_hero_btn2_video_file' => $settings['home_hero_btn2_video_file'] ?? '',
            'home_hero_btn2_video_url' => $settings['home_hero_btn2_video_url'] ?? '',

            'home_about_subtitle' => $settings['home_about_subtitle'] ?? '',
            'home_about_title' => $settings['home_about_title'] ?? '',
            'home_about_styled_title' => $settings['home_about_styled_title'] ?? '',
            'home_about_description' => $settings['home_about_description'] ?? '',
            'home_about_image' => !empty($settings['home_about_image']) ? [$settings['home_about_image']] : [],
            'home_about_image_alt' => $settings['home_about_image_alt'] ?? '',
            'home_about_btn_label' => $settings['home_about_btn_label'] ?? '',
            'home_about_btn_url' => $settings['home_about_btn_url'] ?? '',

            'home_brands_subtitle' => $settings['home_brands_subtitle'] ?? '',
            'home_brands_title' => $settings['home_brands_title'] ?? '',
            'home_brands_description' => $settings['home_brands_description'] ?? '',
            'home_showreel_subtitle' => $settings['home_showreel_subtitle'] ?? '',
            'home_showreel_title' => $settings['home_showreel_title'] ?? '',
            'home_showreel_description' => $settings['home_showreel_description'] ?? '',
            'home_showreel_video_url' => $settings['home_showreel_video_url'] ?? '',
            'home_showreel_2_subtitle' => $settings['home_showreel_2_subtitle'] ?? '',
            'home_showreel_2_title' => $settings['home_showreel_2_title'] ?? '',
            'home_showreel_2_description' => $settings['home_showreel_2_description'] ?? '',
            'home_showreel_2_video_url' => $settings['home_showreel_2_video_url'] ?? '',
            'home_showreel_3_subtitle' => $settings['home_showreel_3_subtitle'] ?? '',
            'home_showreel_3_title' => $settings['home_showreel_3_title'] ?? '',
            'home_showreel_3_description' => $settings['home_showreel_3_description'] ?? '',
            'home_showreel_3_video_url' => $settings['home_showreel_3_video_url'] ?? '',
            'home_services_subtitle' => $settings['home_services_subtitle'] ?? '',
            'home_services_title' => $settings['home_services_title'] ?? '',
            'home_services_description' => $settings['home_services_description'] ?? '',
            'home_services_cta_label' => $settings['home_services_cta_label'] ?? '',
            'home_services_cta_url' => $settings['home_services_cta_url'] ?? '',
            'home_portfolio_subtitle' => $settings['home_portfolio_subtitle'] ?? '',
            'home_portfolio_title' => $settings['home_portfolio_title'] ?? '',
            'home_portfolio_description' => $settings['home_portfolio_description'] ?? '',
            'home_stats_subtitle' => $settings['home_stats_subtitle'] ?? '',
            'home_stats_title' => $settings['home_stats_title'] ?? '',
            'home_stats_description' => $settings['home_stats_description'] ?? '',
            'home_testimonials_subtitle' => $settings['home_testimonials_subtitle'] ?? '',
            'home_testimonials_title' => $settings['home_testimonials_title'] ?? '',
            'home_testimonials_description' => $settings['home_testimonials_description'] ?? '',
            'home_blog_subtitle' => $settings['home_blog_subtitle'] ?? '',
            'home_blog_title' => $settings['home_blog_title'] ?? '',
            'home_blog_description' => $settings['home_blog_description'] ?? '',
            'home_brands_styled_title' => $settings['home_brands_styled_title'] ?? '',
            'home_showreel_styled_title' => $settings['home_showreel_styled_title'] ?? '',
            'home_showreel_2_styled_title' => $settings['home_showreel_2_styled_title'] ?? '',
            'home_showreel_3_styled_title' => $settings['home_showreel_3_styled_title'] ?? '',
            'home_services_styled_title' => $settings['home_services_styled_title'] ?? '',
            'home_portfolio_styled_title' => $settings['home_portfolio_styled_title'] ?? '',
            'home_stats_styled_title' => $settings['home_stats_styled_title'] ?? '',
            'home_testimonials_styled_title' => $settings['home_testimonials_styled_title'] ?? '',
            'home_blog_styled_title' => $settings['home_blog_styled_title'] ?? '',

            'spotlight_title' => $settings['spotlight_title'] ?? '',
            'spotlight_subtitle' => $settings['spotlight_subtitle'] ?? '',
            'spotlight_description' => $settings['spotlight_description'] ?? '',
            'spotlight_video_url' => $settings['spotlight_video_url'] ?? '',
            'spotlight_badge_label' => $settings['spotlight_badge_label'] ?? '',
            'spotlight_highlight_1_icon' => $settings['spotlight_highlight_1_icon'] ?? '',
            'spotlight_highlight_1_title' => $settings['spotlight_highlight_1_title'] ?? '',
            'spotlight_highlight_1_sub' => $settings['spotlight_highlight_1_sub'] ?? '',
            'spotlight_highlight_2_icon' => $settings['spotlight_highlight_2_icon'] ?? '',
            'spotlight_highlight_2_title' => $settings['spotlight_highlight_2_title'] ?? '',
            'spotlight_highlight_2_sub' => $settings['spotlight_highlight_2_sub'] ?? '',
            'spotlight_cta_label' => $settings['spotlight_cta_label'] ?? '',
            'spotlight_cta2_label' => $settings['spotlight_cta2_label'] ?? '',
            'spotlight_cta2_url' => $settings['spotlight_cta2_url'] ?? '',
            'spotlight_styled_title' => $settings['spotlight_styled_title'] ?? '',
            'spotlight_title_suffix' => $settings['spotlight_title_suffix'] ?? '',
            'spotlight_video_source' => $settings['spotlight_video_source'] ?? 'url',
            'spotlight_video_file' => $settings['spotlight_video_file'] ?? '',

            'stat_projects' => $settings['stat_projects'] ?? '200',
            'stat_awards' => $settings['stat_awards'] ?? '15',
            'stat_years' => $settings['stat_years'] ?? '10',
            'stat_partners' => $settings['stat_partners'] ?? '50',

            'home_blog_count' => $settings['home_blog_count'] ?? '3',
            'home_blog_btn_label' => $settings['home_blog_btn_label'] ?? '',

            'home_support_subtitle' => $settings['home_support_subtitle'] ?? '',
            'home_support_title' => $settings['home_support_title'] ?? '',
            'home_support_styled_title' => $settings['home_support_styled_title'] ?? '',
            'home_support_c1_title' => $settings['home_support_c1_title'] ?? '',
            'home_support_c1_desc' => $settings['home_support_c1_desc'] ?? '',
            'home_support_c1_icon' => $settings['home_support_c1_icon'] ?? '',
            'home_support_c1_image' => !empty($settings['home_support_c1_image']) ? [$settings['home_support_c1_image']] : [],
            'home_support_c1_image_alt' => $settings['home_support_c1_image_alt'] ?? '',
            'home_support_c2_title' => $settings['home_support_c2_title'] ?? '',
            'home_support_c2_desc' => $settings['home_support_c2_desc'] ?? '',
            'home_support_c2_icon' => $settings['home_support_c2_icon'] ?? '',
            'home_support_c2_image' => !empty($settings['home_support_c2_image']) ? [$settings['home_support_c2_image']] : [],
            'home_support_c2_image_alt' => $settings['home_support_c2_image_alt'] ?? '',
            'home_support_c3_title' => $settings['home_support_c3_title'] ?? '',
            'home_support_c3_desc' => $settings['home_support_c3_desc'] ?? '',
            'home_support_c3_icon' => $settings['home_support_c3_icon'] ?? '',
            'home_support_c3_image' => !empty($settings['home_support_c3_image']) ? [$settings['home_support_c3_image']] : [],
            'home_support_c3_image_alt' => $settings['home_support_c3_image_alt'] ?? '',
            'home_support_c4_title' => $settings['home_support_c4_title'] ?? '',
            'home_support_c4_desc' => $settings['home_support_c4_desc'] ?? '',
            'home_support_c4_icon' => $settings['home_support_c4_icon'] ?? '',
            'home_support_c4_image' => !empty($settings['home_support_c4_image']) ? [$settings['home_support_c4_image']] : [],
            'home_support_c4_image_alt' => $settings['home_support_c4_image_alt'] ?? '',
        ]);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Homepage Settings')
                ->tabs([
                    Tab::make('Hero')
                        ->icon('heroicon-o-rocket-launch')
                        ->schema([
                            Section::make('Video Background')
                                ->schema([
                                    TextInput::make('home_hero_video_url')
                                        ->label('Background Video URL')
                                        ->helperText('YouTube Embed URL or Direct MP4 link.')
                                        ->placeholder('https://www.youtube.com/embed/QEl1eppPS40?autoplay=1&mute=1&...'),
                                ]),

                            Section::make('Hero Content')
                                ->schema([
                                    TextInput::make('home_hero_status_text')
                                        ->label('Pill Badge Text')
                                        ->placeholder('PRODUCTION_STREAM_ACTIVE'),
                                    TextInput::make('home_hero_subtitle')
                                        ->label('Hero Subtitle')
                                        ->placeholder('Premier Production House'),
                                    TextInput::make('home_hero_title_line1')
                                        ->label('Title Line 1')
                                        ->placeholder('Cinematic'),
                                    TextInput::make('home_hero_title_line2')
                                        ->label('Title Line 2 (Highlighted)')
                                        ->placeholder('Excellence'),
                                    Textarea::make('home_hero_description')
                                        ->label('Description')
                                        ->rows(3)
                                        ->columnSpanFull(),
                                ])->columns(2),

                            Section::make('Call to Action Buttons')
                                ->schema([
                                    Section::make('Button 1')
                                        ->schema([
                                            TextInput::make('home_hero_btn1_label')->label('Label'),
                                            Select::make('home_hero_btn1_type')
                                                ->label('Action Type')
                                                ->options([
                                                    'link' => 'Direct Link',
                                                    'video' => 'Video Popup',
                                                ])->live(),
                                            TextInput::make('home_hero_btn1_url')
                                                ->label('Target URL')
                                                ->visible(fn(\Filament\Schemas\Components\Utilities\Get $get) => $get('home_hero_btn1_type') === 'link'),
                                            Select::make('home_hero_btn1_video_source')
                                                ->label('Video Source')
                                                ->options([
                                                    'url' => 'External URL (YouTube/MP4)',
                                                    'upload' => 'Direct Upload',
                                                ])->live()
                                                ->visible(fn(\Filament\Schemas\Components\Utilities\Get $get) => $get('home_hero_btn1_type') === 'video'),
                                            TextInput::make('home_hero_btn1_video_url')
                                                ->label('Video URL')
                                                ->placeholder('https://www.youtube.com/embed/...')
                                                ->visible(fn(\Filament\Schemas\Components\Utilities\Get $get) => $get('home_hero_btn1_type') === 'video' && $get('home_hero_btn1_video_source') === 'url'),
                                            FileUpload::make('home_hero_btn1_video_file')
                                                ->label('Video File')
                                                ->disk('public')
                                                ->maxSize(102400)
                                                ->directory('home-videos')
                                                ->visible(fn(\Filament\Schemas\Components\Utilities\Get $get) => $get('home_hero_btn1_type') === 'video' && $get('home_hero_btn1_video_source') === 'upload'),
                                        ])->columns(2),

                                    Section::make('Button 2')
                                        ->schema([
                                            TextInput::make('home_hero_btn2_label')->label('Label'),
                                            Select::make('home_hero_btn2_type')
                                                ->label('Action Type')
                                                ->options([
                                                    'link' => 'Direct Link',
                                                    'video' => 'Video Popup',
                                                ])->live(),
                                            TextInput::make('home_hero_btn2_url')
                                                ->label('Target URL')
                                                ->visible(fn(\Filament\Schemas\Components\Utilities\Get $get) => $get('home_hero_btn2_type') === 'link'),
                                            Select::make('home_hero_btn2_video_source')
                                                ->label('Video Source')
                                                ->options([
                                                    'url' => 'External URL (YouTube/MP4)',
                                                    'upload' => 'Direct Upload',
                                                ])->live()
                                                ->visible(fn(\Filament\Schemas\Components\Utilities\Get $get) => $get('home_hero_btn2_type') === 'video'),
                                            TextInput::make('home_hero_btn2_video_url')
                                                ->label('Video URL')
                                                ->placeholder('https://www.youtube.com/embed/...')
                                                ->visible(fn(\Filament\Schemas\Components\Utilities\Get $get) => $get('home_hero_btn2_type') === 'video' && $get('home_hero_btn2_video_source') === 'url'),
                                            FileUpload::make('home_hero_btn2_video_file')
                                                ->label('Video File')
                                                ->directory('home-videos')
                                                ->visible(fn(\Filament\Schemas\Components\Utilities\Get $get) => $get('home_hero_btn2_type') === 'video' && $get('home_hero_btn2_video_source') === 'upload'),
                                        ])->columns(2),
                                ]),
                        ]),

                    Tab::make('About Section')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Section::make('Content')
                                ->schema([
                                    TextInput::make('home_about_subtitle')
                                        ->label('Subtitle')
                                        ->default('Who We Are')
                                        ->placeholder('Who We Are'),
                                    TextInput::make('home_about_title')
                                        ->label('Title')
                                        ->default('Nepal Film Production')
                                        ->placeholder('Nepal Film Production'),
                                    TextInput::make('home_about_styled_title')
                                        ->label('Styled Title (Highlighted)')
                                        ->default('Our Story')
                                        ->placeholder('Our Story'),
                                    Textarea::make('home_about_description')
                                        ->label('Description')
                                        ->default('We are a premier production house based in the heart of Nepal, delivering world-class film and media production services. With a passionate team of creatives, cutting-edge equipment, and breathtaking locations, we bring stories to life that captivate audiences worldwide.')
                                        ->rows(5)
                                        ->columnSpanFull(),
                                    TextInput::make('home_about_btn_label')
                                        ->label('Button Label')
                                        ->default('Learn More')
                                        ->placeholder('Learn More'),
                                    TextInput::make('home_about_btn_url')
                                        ->label('Button URL')
                                        ->default('/about')
                                        ->placeholder('/about'),
                                ])->columns(2),
                            Section::make('Image')
                                ->schema([
                                    FileUpload::make('home_about_image')
                                        ->label('Section Image')
                                        ->disk('public')
                                        ->directory('home-about')
                                        ->image()
                                        ->imageResizeMode('cover')
                                        ->imageCropAspectRatio('4:3')
                                        ->imageResizeTargetWidth(1200)
                                        ->imageResizeTargetHeight(900)
                                        ->columnSpanFull(),
                                    TextInput::make('home_about_image_alt')
                                        ->label('Image Alt Text')
                                        ->default('Nepal Film Production team at work')
                                        ->placeholder('Describe the image for accessibility')
                                        ->columnSpanFull(),
                                ]),
                        ]),

                    Tab::make('Section Headers')
                        ->icon('heroicon-o-rectangle-stack')
                        ->schema([
                            Section::make('Brands')
                                ->schema([
                                    TextInput::make('home_brands_subtitle')->label('Subtitle'),
                                    TextInput::make('home_brands_title')->label('Title'),
                                    TextInput::make('home_brands_styled_title')->label('Styled Title'),
                                    Textarea::make('home_brands_description')->label('Description')->rows(2)->columnSpanFull(),
                                ])->columns(2),
                            Section::make('Showreel')
                                ->schema([
                                    TextInput::make('home_showreel_subtitle')->label('Subtitle'),
                                    TextInput::make('home_showreel_title')->label('Title'),
                                    TextInput::make('home_showreel_styled_title')->label('Styled Title'),
                                    TextInput::make('home_showreel_video_url')
                                        ->label('Video URL')
                                        ->helperText('YouTube URL or Direct MP4 link.')
                                        ->columnSpanFull(),
                                    Textarea::make('home_showreel_description')->label('Description')->rows(2)->columnSpanFull(),
                                ])->columns(2),
                            Section::make('Showreel 2')
                                ->schema([
                                    TextInput::make('home_showreel_2_subtitle')->label('Subtitle'),
                                    TextInput::make('home_showreel_2_title')->label('Title'),
                                    TextInput::make('home_showreel_2_styled_title')->label('Styled Title'),
                                    TextInput::make('home_showreel_2_video_url')
                                        ->label('Video URL')
                                        ->helperText('YouTube URL or Direct MP4 link.')
                                        ->columnSpanFull(),
                                    Textarea::make('home_showreel_2_description')->label('Description')->rows(2)->columnSpanFull(),
                                ])->columns(2),
                            Section::make('Showreel 3')
                                ->schema([
                                    TextInput::make('home_showreel_3_subtitle')->label('Subtitle'),
                                    TextInput::make('home_showreel_3_title')->label('Title'),
                                    TextInput::make('home_showreel_3_styled_title')->label('Styled Title'),
                                    TextInput::make('home_showreel_3_video_url')
                                        ->label('Video URL')
                                        ->helperText('YouTube URL or Direct MP4 link.')
                                        ->columnSpanFull(),
                                    Textarea::make('home_showreel_3_description')->label('Description')->rows(2)->columnSpanFull(),
                                ])->columns(2),
                            Section::make('Services')
                                ->schema([
                                    TextInput::make('home_services_subtitle')->label('Subtitle'),
                                    TextInput::make('home_services_title')->label('Title'),
                                    TextInput::make('home_services_styled_title')->label('Styled Title'),
                                    Textarea::make('home_services_description')->label('Description')->rows(2)->columnSpanFull(),
                                    TextInput::make('home_services_cta_label')->label('CTA Label'),
                                    TextInput::make('home_services_cta_url')->label('CTA URL'),
                                ])->columns(2),
                            Section::make('Portfolio')
                                ->schema([
                                    TextInput::make('home_portfolio_subtitle')->label('Subtitle'),
                                    TextInput::make('home_portfolio_title')->label('Title'),
                                    TextInput::make('home_portfolio_styled_title')->label('Styled Title'),
                                    Textarea::make('home_portfolio_description')->label('Description')->rows(2)->columnSpanFull(),
                                ])->columns(2),
                            Section::make('Stats')
                                ->schema([
                                    TextInput::make('home_stats_subtitle')->label('Subtitle'),
                                    TextInput::make('home_stats_title')->label('Title'),
                                    TextInput::make('home_stats_styled_title')->label('Styled Title'),
                                    Textarea::make('home_stats_description')->label('Description')->rows(2)->columnSpanFull(),
                                ])->columns(2),
                            Section::make('Testimonials')
                                ->schema([
                                    TextInput::make('home_testimonials_subtitle')->label('Subtitle'),
                                    TextInput::make('home_testimonials_title')->label('Title'),
                                    TextInput::make('home_testimonials_styled_title')->label('Styled Title'),
                                    Textarea::make('home_testimonials_description')->label('Description')->rows(2)->columnSpanFull(),
                                ])->columns(2),
                            Section::make('Blog')
                                ->schema([
                                    TextInput::make('home_blog_subtitle')->label('Subtitle'),
                                    TextInput::make('home_blog_title')->label('Title'),
                                    TextInput::make('home_blog_styled_title')->label('Styled Title'),
                                    Textarea::make('home_blog_description')->label('Description')->rows(2)->columnSpanFull(),
                                ])->columns(2),
                        ]),

                    Tab::make('Spotlight')
                        ->icon('heroicon-o-film')
                        ->schema([
                            Section::make('Featured Testimonial')
                                ->schema([
                                    TextInput::make('spotlight_title')->label('Title (Prefix)'),
                                    TextInput::make('spotlight_styled_title')->label('Styled Title'),
                                    TextInput::make('spotlight_title_suffix')->label('Title Suffix'),
                                    TextInput::make('spotlight_subtitle')->label('Subtitle'),
                                    Textarea::make('spotlight_description')->label('Description')->rows(4)->columnSpanFull(),
                                    Select::make('spotlight_video_source')
                                        ->label('Video Source')
                                        ->options([
                                            'url' => 'External URL (YouTube/MP4)',
                                            'upload' => 'Direct Upload',
                                        ])->live(),
                                    TextInput::make('spotlight_video_url')
                                        ->label('Video URL')
                                        ->visible(fn(\Filament\Schemas\Components\Utilities\Get $get) => $get('spotlight_video_source') === 'url'),
                                    FileUpload::make('spotlight_video_file')
                                        ->label('Video File')
                                        ->disk('public')
                                        ->maxSize(102400)
                                        ->directory('home-videos')
                                        ->visible(fn(\Filament\Schemas\Components\Utilities\Get $get) => $get('spotlight_video_source') === 'upload'),
                                    TextInput::make('spotlight_badge_label')->label('Badge Label'),
                                    TextInput::make('spotlight_cta_label')->label('Video CTA Label'),
                                    TextInput::make('spotlight_cta2_label')->label('Link CTA Label'),
                                    TextInput::make('spotlight_cta2_url')->label('Link CTA URL'),
                                ])->columns(2),
                            Section::make('Highlights')
                                ->schema([
                                    TextInput::make('spotlight_highlight_1_icon')->label('Icon 1'),
                                    TextInput::make('spotlight_highlight_1_title')->label('Title 1'),
                                    TextInput::make('spotlight_highlight_1_sub')->label('Sub 1'),
                                    TextInput::make('spotlight_highlight_2_icon')->label('Icon 2'),
                                    TextInput::make('spotlight_highlight_2_title')->label('Title 2'),
                                    TextInput::make('spotlight_highlight_2_sub')->label('Sub 2'),
                                ])->columns(3),
                        ]),

                    Tab::make('Stats & Metrics')
                        ->icon('heroicon-o-chart-bar')
                        ->schema([
                            Section::make('Counters')
                                ->schema([
                                    TextInput::make('stat_projects')->label('Projects Done')->numeric(),
                                    TextInput::make('stat_awards')->label('Awards Won')->numeric(),
                                    TextInput::make('stat_years')->label('Years Active')->numeric(),
                                    TextInput::make('stat_partners')->label('Global Partners')->numeric(),
                                ])->columns(2),
                        ]),

                    Tab::make('Blog & Feeds')
                        ->icon('heroicon-o-newspaper')
                        ->schema([
                            Section::make('Configuration')
                                ->schema([
                                    TextInput::make('home_blog_count')
                                        ->label('Posts to show')
                                        ->numeric()
                                        ->default(3),
                                    TextInput::make('home_blog_btn_label')
                                        ->label('Archive Button Label')
                                        ->placeholder('Dispatch Archive'),
                                ])->columns(2),
                        ]),

                    Tab::make('International Support')
                        ->icon('heroicon-o-globe-alt')
                        ->schema([
                            Section::make('Header')
                                ->schema([
                                    TextInput::make('home_support_subtitle')->label('Subtitle'),
                                    TextInput::make('home_support_title')->label('Title'),
                                    TextInput::make('home_support_styled_title')->label('Styled Title'),
                                ])->columns(3),
                            Section::make('Support for USA Crews')
                                ->schema([
                                    TextInput::make('home_support_c1_title')->label('Title'),
                                    TextInput::make('home_support_c1_icon')->label('Icon (Material Icon Name)'),
                                    Textarea::make('home_support_c1_desc')->label('Description')->rows(3)->columnSpanFull(),
                                    FileUpload::make('home_support_c1_image')
                                        ->label('Card Image')
                                        ->disk('public')
                                        ->directory('home-support')
                                        ->image()
                                        ->imageResizeMode('cover')
                                        ->imageCropAspectRatio('16:9')
                                        ->imageResizeTargetWidth(800)
                                        ->imageResizeTargetHeight(450),
                                    TextInput::make('home_support_c1_image_alt')->label('Image Alt Text'),
                                ])->columns(2),
                            Section::make('Support for European, Australian & Asian Teams')
                                ->schema([
                                    TextInput::make('home_support_c2_title')->label('Title'),
                                    TextInput::make('home_support_c2_icon')->label('Icon (Material Icon Name)'),
                                    Textarea::make('home_support_c2_desc')->label('Description')->rows(3)->columnSpanFull(),
                                    FileUpload::make('home_support_c2_image')
                                        ->label('Card Image')
                                        ->disk('public')
                                        ->directory('home-support')
                                        ->image()
                                        ->imageResizeMode('cover')
                                        ->imageCropAspectRatio('16:9')
                                        ->imageResizeTargetWidth(800)
                                        ->imageResizeTargetHeight(450),
                                    TextInput::make('home_support_c2_image_alt')->label('Image Alt Text'),
                                ])->columns(2),
                            Section::make('UK Film & Broadcast Production Managements')
                                ->schema([
                                    TextInput::make('home_support_c3_title')->label('Title'),
                                    TextInput::make('home_support_c3_icon')->label('Icon (Material Icon Name)'),
                                    Textarea::make('home_support_c3_desc')->label('Description')->rows(3)->columnSpanFull(),
                                    FileUpload::make('home_support_c3_image')
                                        ->label('Card Image')
                                        ->disk('public')
                                        ->directory('home-support')
                                        ->image()
                                        ->imageResizeMode('cover')
                                        ->imageCropAspectRatio('16:9')
                                        ->imageResizeTargetWidth(800)
                                        ->imageResizeTargetHeight(450),
                                    TextInput::make('home_support_c3_image_alt')->label('Image Alt Text'),
                                ])->columns(2),
                            Section::make('Production Partner From Kathmandu-Himalayas')
                                ->schema([
                                    TextInput::make('home_support_c4_title')->label('Title'),
                                    TextInput::make('home_support_c4_icon')->label('Icon (Material Icon Name)'),
                                    Textarea::make('home_support_c4_desc')->label('Description')->rows(3)->columnSpanFull(),
                                    FileUpload::make('home_support_c4_image')
                                        ->label('Card Image')
                                        ->disk('public')
                                        ->directory('home-support')
                                        ->image()
                                        ->imageResizeMode('cover')
                                        ->imageCropAspectRatio('16:9')
                                        ->imageResizeTargetWidth(800)
                                        ->imageResizeTargetHeight(450),
                                    TextInput::make('home_support_c4_image_alt')->label('Image Alt Text'),
                                ])->columns(2),
                        ]),
                ])
                ->columnSpanFull(),
        ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // FileUpload returns array, store as string path
        if (isset($data['home_about_image']) && is_array($data['home_about_image'])) {
            $data['home_about_image'] = collect($data['home_about_image'])->first() ?? '';
        }
        foreach (['home_support_c1_image', 'home_support_c2_image', 'home_support_c3_image', 'home_support_c4_image'] as $imageKey) {
            if (isset($data[$imageKey]) && is_array($data[$imageKey])) {
                $data[$imageKey] = collect($data[$imageKey])->first() ?? '';
            }
        }

        foreach ($data as $key => $value) {
            Setting::set($key, $value ?? '');
        }

        Setting::flushCache();

        Notification::make()
            ->title('Homepage Settings saved successfully!')
            ->success()
            ->send();
    }
}
