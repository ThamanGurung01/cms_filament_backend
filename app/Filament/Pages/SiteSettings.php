<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use UnitEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class SiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Site Settings';
    protected static string|UnitEnum|null $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.site-settings';

    /**
     * Only superadmins can access Site Settings.
     */
    public static function canAccess(): bool
    {
        return auth()->user()?->isSuperAdmin() ?? false;
    }

    public function getMaxContentWidth(): \Filament\Support\Enums\Width|string|null
    {
        return \Filament\Support\Enums\Width::Full;
    }

    // General
    public ?string $site_name = '';
    public ?string $site_tagline = '';
    public ?string $site_email = '';
    public ?string $site_phone = '';
    public ?string $site_address = '';
    public ?string $site_whatsapp = '';
    public ?string $site_copyright = '';
    public mixed $site_logo = null;
    public mixed $site_favicon = null;
    public ?string $site_primary_color = '#0668a7';
    public ?string $site_author_name = '';
    public ?string $site_author_role = '';
    public mixed $site_author_avatar = null;

    // Emails
    public ?string $admin_email = '';

    // Header Layout
    public ?string $header_menu_id = '';
    public ?string $header_btn_label = '';
    public ?string $header_btn_url = '';
    public ?string $header_btn_target = '_self';

    // Footer Layout
    public ?string $footer_col3_heading = '';
    public ?string $footer_col3_menu_id = '';
    public ?string $footer_col4_heading = '';
    public ?string $footer_col4_menu_id = '';
    public ?string $footer_bottom_menu_id = '';

    // SEO
    public ?string $seo_title = '';
    public ?string $seo_description = '';
    public ?string $seo_keywords = '';
    public mixed $seo_og_image = null;

    // Socials
    public ?string $social_facebook = '';
    public ?string $social_instagram = '';
    public ?string $social_youtube = '';
    public ?string $social_twitter = '';
    public ?string $social_linkedin = '';
    public ?string $social_tiktok = '';

    // Code Injection
    public ?string $inject_header = '';
    public ?string $inject_footer = '';

    public ?string $spotlight_cta_label         = '';

    public function mount(): void
    {
        $settings = Setting::map();

        $this->form->fill([
            'site_name'       => $settings['site_name'] ?? '',
            'site_tagline'    => $settings['site_tagline'] ?? '',
            'site_email'      => $settings['site_email'] ?? '',
            'site_phone'      => $settings['site_phone'] ?? '',
            'site_address'    => $settings['site_address'] ?? '',
            'site_whatsapp'   => $settings['site_whatsapp'] ?? '',
            'site_copyright'  => $settings['site_copyright'] ?? '',
            'site_logo'       => !empty($settings['site_logo']) ? [$settings['site_logo'] => $settings['site_logo']] : null,
            'site_favicon'    => !empty($settings['site_favicon']) ? [$settings['site_favicon'] => $settings['site_favicon']] : null,
            'site_primary_color' => $settings['site_primary_color'] ?? '#0668a7',
            'site_author_name' => $settings['site_author_name'] ?? '',
            'site_author_role' => $settings['site_author_role'] ?? '',
            'site_author_avatar' => !empty($settings['site_author_avatar']) ? [$settings['site_author_avatar'] => $settings['site_author_avatar']] : null,

            'admin_email'     => $settings['admin_email'] ?? '',

            'header_menu_id'      => $settings['header_menu_id'] ?? '',
            'header_btn_label'    => $settings['header_btn_label'] ?? '',
            'header_btn_url'      => $settings['header_btn_url'] ?? '',
            'header_btn_target'   => $settings['header_btn_target'] ?? '_self',

            'footer_col3_heading'   => $settings['footer_col3_heading'] ?? '',
            'footer_col3_menu_id'   => $settings['footer_col3_menu_id'] ?? '',
            'footer_col4_heading'   => $settings['footer_col4_heading'] ?? '',
            'footer_col4_menu_id'   => $settings['footer_col4_menu_id'] ?? '',
            'footer_bottom_menu_id' => $settings['footer_bottom_menu_id'] ?? '',

            'seo_title'       => $settings['seo_title'] ?? '',
            'seo_description' => $settings['seo_description'] ?? '',
            'seo_keywords'    => $settings['seo_keywords'] ?? '',
            'seo_og_image'    => !empty($settings['seo_og_image']) ? [$settings['seo_og_image'] => $settings['seo_og_image']] : null,

            'social_facebook'  => $settings['social_facebook'] ?? '',
            'social_instagram'  => $settings['social_instagram'] ?? '',
            'social_youtube'    => $settings['social_youtube'] ?? '',
            'social_twitter'    => $settings['social_twitter'] ?? '',
            'social_linkedin'   => $settings['social_linkedin'] ?? '',
            'social_tiktok'     => $settings['social_tiktok'] ?? '',
            'inject_header' => $settings['inject_header'] ?? '',
            'inject_footer' => $settings['inject_footer'] ?? '',
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Site Settings')
                ->tabs([
                    Tab::make('General')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Section::make('Identity')
                                ->schema([
                                    TextInput::make('site_name')
                                        ->label('Site Name')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('site_tagline')
                                        ->label('Tagline')
                                        ->maxLength(255),
                                    FileUpload::make('site_logo')
                                        ->label('Site Logo')
                                        ->image()
                                        ->disk('public')
                                        ->directory('site')
                                        ->helperText('Replaces the default logo across the site. Recommended height: 40–60px.')
                                        ->columnSpanFull(),
                                    FileUpload::make('site_favicon')
                                        ->label('Favicon')
                                        ->image()
                                        ->disk('public')
                                        ->directory('site')
                                        ->helperText('Browser tab icon. Recommended: 32×32px or 48×48px PNG/ICO.')
                                        ->columnSpanFull(),
                                ])
                                ->columns(2),

                            Section::make('Contact Details')
                                ->schema([
                                    TextInput::make('site_email')
                                        ->label('Email Address')
                                        ->email()
                                        ->maxLength(255),
                                    TextInput::make('site_phone')
                                        ->label('Phone Number')
                                        ->tel()
                                        ->maxLength(50),
                                    TextInput::make('site_whatsapp')
                                        ->label('WhatsApp Number')
                                        ->helperText('Digits only, with country code. E.g. 9779801040899')
                                        ->dehydrateStateUsing(fn ($state) => str_replace(' ', '', $state))
                                        ->maxLength(50),
                                    Textarea::make('site_address')
                                        ->label('Office Address')
                                        ->rows(2),
                                ])
                                ->columns(2),

                            Section::make('Branding & Colors')
                                ->schema([
                                    ColorPicker::make('site_primary_color')
                                        ->label('Primary Theme Color')
                                        ->default('#0668a7')
                                        ->helperText('This color will be used for buttons, links, and accents across the site.'),
                                ])
                                ->columns(1),

                            Section::make('Blog Author (EEAT)')
                                ->description('Define the author details displayed on blog posts for search engine optimization (EEAT) credibility.')
                                ->schema([
                                    TextInput::make('site_author_name')
                                        ->label('Author Name')
                                        ->maxLength(255),
                                    TextInput::make('site_author_role')
                                        ->label('Author Role / Job Title')
                                        ->maxLength(255),
                                    FileUpload::make('site_author_avatar')
                                        ->label('Author Photo')
                                        ->image()
                                        ->disk('public')
                                        ->directory('site')
                                        ->helperText('Recommended size: square (e.g. 150×150px) photo.'),
                                ])
                                ->columns(2),

                            Section::make('Footer')
                                ->schema([
                                    TextInput::make('site_copyright')
                                        ->label('Copyright Text')
                                        ->maxLength(255),
                                ]),
                        ]),

                    Tab::make('Header')
                        ->icon('heroicon-o-view-columns')
                        ->schema([
                            Section::make('Navigation & CTA')
                                ->schema([
                                    Select::make('header_menu_id')
                                        ->label('Main Navigation Menu')
                                        ->options(fn() => \App\Models\Menu::pluck('name', 'id'))
                                        ->searchable(),
                                    TextInput::make('header_btn_label')
                                        ->label('CTA Button Label')
                                        ->placeholder('Get a Quote'),
                                    TextInput::make('header_btn_url')
                                        ->label('CTA Button URL')
                                        ->placeholder('/contact'),
                                    Select::make('header_btn_target')
                                        ->label('CTA Button Target')
                                        ->options([
                                            '_self' => 'Same Window',
                                            '_blank' => 'New Tab',
                                        ])->default('_self'),
                                ])->columns(2),
                        ]),

                    Tab::make('Footer Layout')
                        ->icon('heroicon-o-table-cells')
                        ->schema([
                            Section::make('Column 2 (Contact)')
                                ->schema([
                                    TextInput::make('footer_col2_heading')
                                        ->label('Column Heading')
                                        ->placeholder('Contact Us'),
                                ])->columns(1),
                            Section::make('Column 3 (Navigation)')
                                ->schema([
                                    TextInput::make('footer_col3_heading')
                                        ->label('Column Heading')
                                        ->placeholder('Our Services'),
                                    Select::make('footer_col3_menu_id')
                                        ->label('Menu')
                                        ->options(fn() => \App\Models\Menu::pluck('name', 'id'))
                                        ->searchable(),
                                ])->columns(2),
                            Section::make('Column 4 (Company)')
                                ->schema([
                                    TextInput::make('footer_col4_heading')
                                        ->label('Column Heading')
                                        ->placeholder('Company'),
                                    Select::make('footer_col4_menu_id')
                                        ->label('Menu')
                                        ->options(fn() => \App\Models\Menu::pluck('name', 'id'))
                                        ->searchable(),
                                ])->columns(2),
                            Section::make('Bottom Footer')
                                ->schema([
                                    Select::make('footer_bottom_menu_id')
                                        ->label('Bottom Right Menu')
                                        ->options(fn() => \App\Models\Menu::pluck('name', 'id'))
                                        ->searchable(),
                                ]),
                        ]),

                    Tab::make('Global SEO')
                        ->icon('heroicon-o-globe-alt')
                        ->schema([
                            Section::make('Default Meta Tags')
                                ->description('These apply as the site-wide fallback. Individual pages can override them.')
                                ->schema([
                                    TextInput::make('seo_title')
                                        ->label('Default Page Title')
                                        ->helperText('Shown in browser tab and search results. Max 70 chars.'),
                                    Textarea::make('seo_description')
                                        ->label('Meta Description')
                                        ->rows(3)
                                        ->helperText('Shown in search engine snippets. Max 160 chars.'),
                                    TextInput::make('seo_keywords')
                                        ->label('Meta Keywords')
                                        ->helperText('Comma-separated keywords.'),
                                    FileUpload::make('seo_og_image')
                                        ->label('OG / Social Share Image')
                                        ->image()
                                        ->disk('public')
                                        ->directory('seo')
                                        ->helperText('Recommended 1200x630px. Shown when links are shared on social media.')
                                        ->columnSpanFull(),
                                ])
                                ->columns(1),
                        ]),

                    Tab::make('Socials')
                        ->icon('heroicon-o-share')
                        ->schema([
                            Section::make('Social Media Links')
                                ->description('Leave blank to hide the icon.')
                                ->schema([
                                    TextInput::make('social_facebook')
                                        ->label('Facebook URL')
                                        ->url()
                                        ->prefix('facebook.com')
                                        ->prefixIcon('heroicon-o-link'),
                                    TextInput::make('social_instagram')
                                        ->label('Instagram URL')
                                        ->url()
                                        ->prefixIcon('heroicon-o-link'),
                                    TextInput::make('social_youtube')
                                        ->label('YouTube URL')
                                        ->url()
                                        ->prefixIcon('heroicon-o-link'),
                                    TextInput::make('social_twitter')
                                        ->label('Twitter / X URL')
                                        ->url()
                                        ->prefixIcon('heroicon-o-link'),
                                    TextInput::make('social_linkedin')
                                        ->label('LinkedIn URL')
                                        ->url()
                                        ->prefixIcon('heroicon-o-link'),
                                    TextInput::make('social_tiktok')
                                        ->label('TikTok URL')
                                        ->url()
                                        ->prefixIcon('heroicon-o-link'),
                                ])
                                ->columns(2),
                        ]),

                    Tab::make('Email')
                        ->icon('heroicon-o-envelope')
                        ->schema([
                            Section::make('Notification Settings')
                                ->description('Configure where system notifications (like contact form inquiries) should be sent.')
                                ->schema([
                                    TextInput::make('admin_email')
                                        ->label('Admin Notification Email')
                                        ->email()
                                        ->required()
                                        ->helperText('All contact form submissions will be sent to this email address.'),
                                ]),
                        ]),

                    Tab::make('Insert into Header')
                        ->icon('heroicon-o-code-bracket')
                        ->schema([
                            Section::make('Custom Header Code')
                                ->description('Injected just before the closing </head> tag on every page. Useful for analytics scripts, custom fonts, tracking pixels, or CSS overrides.')
                                ->schema([
                                    Textarea::make('inject_header')
                                        ->label('')
                                        ->rows(16)
                                        ->placeholder("<!-- Example: Google Analytics -->\n<script async src=\"https://www.googletagmanager.com/gtag/js?id=G-XXXXXXX\"></script>\n<script>\n  window.dataLayer = window.dataLayer || [];\n  function gtag(){dataLayer.push(arguments);}\n  gtag('js', new Date());\n  gtag('config', 'G-XXXXXXX');\n</script>")
                                        ->extraAttributes(['class' => 'font-mono text-xs', 'spellcheck' => 'false'])
                                        ->columnSpanFull(),
                                ]),
                        ]),

                    Tab::make('Insert into Footer')
                        ->icon('heroicon-o-code-bracket-square')
                        ->schema([
                            Section::make('Custom Footer Code')
                                ->description('Injected just before the closing </body> tag on every page. Useful for chat widgets, conversion scripts, or deferred JS.')
                                ->schema([
                                    Textarea::make('inject_footer')
                                        ->label('')
                                        ->rows(16)
                                        ->placeholder("<!-- Example: Hotjar -->\n<script>\n  (function(h,o,t,j,a,r){\n    h.hj=h.hj||function(){...};\n  })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');\n</script>")
                                        ->extraAttributes(['class' => 'font-mono text-xs', 'spellcheck' => 'false'])
                                        ->columnSpanFull(),
                                ]),
                        ]),
                ])
                ->columnSpanFull(),
        ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            // FileUpload fields return arrays; persist only the first path
            if (in_array($key, ['seo_og_image', 'site_logo', 'site_favicon', 'site_author_avatar']) && is_array($value)) {
                $value = count($value) > 0 ? array_values($value)[0] : '';
            }
            Setting::set($key, $value ?? '');
        }

        // Flush the aggregated cache so views pick up fresh data
        Setting::flushCache();

        Notification::make()
            ->title('Settings saved successfully!')
            ->success()
            ->send();
    }
}
