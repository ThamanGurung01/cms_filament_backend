<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\ContactInquiry;
use App\Models\Faq;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Redirect;
use App\Models\Setting;
use App\Models\SlugSeo;
use App\Models\Testimonial;

class DummyDataSeeder extends Seeder
{
    /**
     * Seed all Filament resources and pages with realistic dummy data.
     */
    public function run(): void
    {
        $this->seedSettings();
        $this->seedMenus();
        $this->seedPages();
        $this->seedSlugSeos();
        $this->seedBlogCategories();
        $this->seedBlogPosts();
        $this->seedFaqs();
        $this->seedTestimonials();
        $this->seedContactInquiries();
        $this->seedRedirects();
    }

    // ─── Settings (SiteSettings & HomepageSettings pages) ────────────────────

    private function seedSettings(): void
    {
        $settings = [
            // General
            'site_name'               => 'Unel Solutions',
            'site_tagline'            => 'Building Smarter Digital Futures',
            'site_email'              => 'hello@unelsolutions.com',
            'site_phone'              => '+1 (800) 555-0199',
            'site_address'            => '250 Innovation Drive, Suite 400, Austin, TX 78701',
            'site_whatsapp'           => '+18005550199',
            'site_copyright'          => '© 2025 Unel Solutions. All rights reserved.',
            'site_primary_color'      => '#0668a7',
            'site_author_name'        => 'Jordan Blake',
            'site_author_role'        => 'Chief Technology Officer',

            // Emails
            'admin_email'             => 'admin@unelsolutions.com',

            // Header Layout
            'header_menu_id'          => '1',
            'header_btn_label'        => 'Get a Free Quote',
            'header_btn_url'          => '/contact',
            'header_btn_target'       => '_self',

            // Footer Layout
            'footer_col3_heading'     => 'Quick Links',
            'footer_col3_menu_id'     => '2',
            'footer_col4_heading'     => 'Services',
            'footer_col4_menu_id'     => '3',
            'footer_bottom_menu_id'   => '4',

            // SEO
            'seo_title'               => 'Unel Solutions – Digital Strategy & Development',
            'seo_description'         => 'Unel Solutions helps businesses grow through bespoke web development, digital strategy, and data-driven marketing campaigns.',
            'seo_keywords'            => 'web development, digital strategy, CMS, Laravel, marketing',

            // Socials
            'social_facebook'         => 'https://www.facebook.com/unelsolutions',
            'social_instagram'        => 'https://www.instagram.com/unelsolutions',
            'social_youtube'          => 'https://www.youtube.com/@unelsolutions',
            'social_twitter'          => 'https://twitter.com/unelsolutions',
            'social_linkedin'         => 'https://www.linkedin.com/company/unelsolutions',
            'social_tiktok'           => 'https://www.tiktok.com/@unelsolutions',

            // Code Injection
            'inject_header'           => '',
            'inject_footer'           => '',

            // Spotlight CTA (legacy key used by SiteSettings)
            'spotlight_cta_label'     => 'Start Your Project',

            // Robots & Sitemap
            'robots_txt_content'      => "User-agent: *\nAllow: /\nDisallow: /admin/\nSitemap: https://unelsolutions.com/sitemap.xml",

            // ── HomepageSettings ──────────────────────────────────────────────

            // Hero Section
            'home_hero_video_url'          => 'https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1&mute=1&loop=1&playlist=dQw4w9WgXcQ',
            'home_hero_status_text'        => 'PRODUCTION_STREAM_ACTIVE',
            'home_hero_subtitle'           => 'Premier Digital Agency',
            'home_hero_title_line1'        => 'Transforming Ideas Into',
            'home_hero_title_line2'        => 'Digital Reality',
            'home_hero_description'        => 'We partner with forward-thinking companies to design, build, and grow remarkable digital products that stand the test of time.',
            'home_hero_btn1_label'         => 'Watch Our Story',
            'home_hero_btn1_type'          => 'video',
            'home_hero_btn1_video_source'  => 'url',
            'home_hero_btn1_video_url'     => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'home_hero_btn1_video_file'    => '',
            'home_hero_btn2_label'         => 'See Our Work',
            'home_hero_btn2_type'          => 'link',
            'home_hero_btn2_url'           => '/portfolio',
            'home_hero_btn2_video_source'  => 'url',
            'home_hero_btn2_video_url'     => '',
            'home_hero_btn2_video_file'    => '',

            // About Section
            'home_about_subtitle'          => 'Who We Are',
            'home_about_title'             => 'Unel Solutions',
            'home_about_styled_title'      => 'Our Story',
            'home_about_description'       => 'Founded in 2015, Unel Solutions has helped over 200 clients across 30 countries achieve their digital ambitions. Our multidisciplinary team combines cutting-edge technology with creative thinking to deliver solutions that last.',
            'home_about_image_alt'         => 'Unel Solutions team at work',
            'home_about_btn_label'         => 'Meet the Team',
            'home_about_btn_url'           => '/about',

            // Section Headers – Brands
            'home_brands_subtitle'         => 'Trusted By',
            'home_brands_title'            => 'Industry',
            'home_brands_styled_title'     => 'Leaders',
            'home_brands_description'      => 'Proud to work with some of the most innovative companies around the globe.',

            // Section Headers – Showreel
            'home_showreel_subtitle'       => 'Our Work',
            'home_showreel_title'          => 'Award-Winning',
            'home_showreel_styled_title'   => 'Projects',
            'home_showreel_description'    => 'A curated selection of the work we are most proud of.',
            'home_showreel_video_url'      => '',

            // Section Headers – Showreel 2
            'home_showreel_2_subtitle'     => 'Behind the Scenes',
            'home_showreel_2_title'        => 'How We',
            'home_showreel_2_styled_title' => 'Build',
            'home_showreel_2_description'  => 'A look into our collaborative process from discovery to delivery.',
            'home_showreel_2_video_url'    => '',

            // Section Headers – Showreel 3
            'home_showreel_3_subtitle'     => 'Case Studies',
            'home_showreel_3_title'        => 'Proven',
            'home_showreel_3_styled_title' => 'Results',
            'home_showreel_3_description'  => 'Real impact, measured and documented.',
            'home_showreel_3_video_url'    => '',

            // Section Headers – Services
            'home_services_subtitle'       => 'What We Do',
            'home_services_title'          => 'End-to-End',
            'home_services_styled_title'   => 'Digital Services',
            'home_services_description'    => 'End-to-end digital services tailored to your business goals.',
            'home_services_cta_label'      => 'View All Services',
            'home_services_cta_url'        => '/services',

            // Section Headers – Portfolio
            'home_portfolio_subtitle'      => 'Our Portfolio',
            'home_portfolio_title'         => 'Selected',
            'home_portfolio_styled_title'  => 'Work',
            'home_portfolio_description'   => 'Explore a selection of our most impactful client projects.',

            // Section Headers – Stats
            'home_stats_subtitle'          => 'By the Numbers',
            'home_stats_title'             => 'Our',
            'home_stats_styled_title'      => 'Impact',
            'home_stats_description'       => 'Metrics that reflect our commitment to excellence.',

            // Section Headers – Testimonials
            'home_testimonials_subtitle'     => 'Client Stories',
            'home_testimonials_title'        => 'What Our',
            'home_testimonials_styled_title' => 'Clients Say',
            'home_testimonials_description'  => 'Don\'t just take our word for it—hear from the businesses we\'ve helped.',

            // Section Headers – Blog
            'home_blog_subtitle'           => 'From the Blog',
            'home_blog_title'              => 'Latest',
            'home_blog_styled_title'       => 'Insights',
            'home_blog_description'        => 'Thoughts, guides, and news from the Unel Solutions team.',

            // Spotlight Section
            'spotlight_title'              => 'Transforming',
            'spotlight_styled_title'       => 'Businesses',
            'spotlight_title_suffix'       => 'Through Technology',
            'spotlight_subtitle'           => 'Client Spotlight',
            'spotlight_description'        => 'We partnered with Apex Retail Group to rebuild their e-commerce platform from the ground up—delivering a 42% uplift in conversion rate within the first quarter.',
            'spotlight_video_source'       => 'url',
            'spotlight_video_url'          => '',
            'spotlight_video_file'         => '',
            'spotlight_badge_label'        => 'Featured Project',
            'spotlight_cta2_label'         => 'View Case Study',
            'spotlight_cta2_url'           => '/portfolio',
            'spotlight_highlight_1_icon'   => 'heroicon-o-arrow-trending-up',
            'spotlight_highlight_1_title'  => '42% Conversion Increase',
            'spotlight_highlight_1_sub'    => 'First quarter post-launch',
            'spotlight_highlight_2_icon'   => 'heroicon-o-clock',
            'spotlight_highlight_2_title'  => '8-Week Delivery',
            'spotlight_highlight_2_sub'    => 'From discovery to go-live',

            // Stats & Metrics
            'stat_projects'                => '450',
            'stat_awards'                  => '28',
            'stat_years'                   => '10',
            'stat_partners'                => '30',

            // Blog & Feeds
            'home_blog_count'              => '3',
            'home_blog_btn_label'          => 'View All Posts',

            // International Support Section
            'home_support_subtitle'        => 'Global Reach',
            'home_support_title'           => 'Serving Clients',
            'home_support_styled_title'    => 'Worldwide',
            'home_support_c1_title'        => 'North America',
            'home_support_c1_desc'         => 'Full-stack web development and digital strategy for US and Canadian businesses, with a focus on performance, scalability, and ROI.',
            'home_support_c1_icon'         => 'flag',
            'home_support_c1_image_alt'    => 'North America operations',
            'home_support_c2_title'        => 'Europe & Australia',
            'home_support_c2_desc'         => 'Partnering with European and Australian companies to deliver GDPR-compliant digital solutions and localised user experiences.',
            'home_support_c2_icon'         => 'public',
            'home_support_c2_image_alt'    => 'Europe and Australia operations',
            'home_support_c3_title'        => 'United Kingdom',
            'home_support_c3_desc'         => 'Trusted by UK businesses for end-to-end web development, CMS implementation, and digital transformation programmes.',
            'home_support_c3_icon'         => 'movie',
            'home_support_c3_image_alt'    => 'UK operations',
            'home_support_c4_title'        => 'Asia-Pacific',
            'home_support_c4_desc'         => 'Supporting fast-growing APAC businesses with modern web applications, API integrations, and cloud infrastructure.',
            'home_support_c4_icon'         => 'landscape',
            'home_support_c4_image_alt'    => 'Asia-Pacific operations',
        ];

        foreach ($settings as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }

    // ─── Menus ────────────────────────────────────────────────────────────────

    private function seedMenus(): void
    {
        $menus = [
            [
                'name' => 'Main Navigation',
                'slug' => 'main-navigation',
                'items' => [
                    ['label' => 'Home',    'url' => '/',         'target' => '_self', 'children' => []],
                    ['label' => 'About',   'url' => '/about',    'target' => '_self', 'children' => []],
                    [
                        'label' => 'Services', 'url' => '/services', 'target' => '_self',
                        'children' => [
                            ['label' => 'Web Development',   'url' => '/services/web-development',   'target' => '_self', 'children' => []],
                            ['label' => 'Digital Marketing', 'url' => '/services/digital-marketing', 'target' => '_self', 'children' => []],
                            ['label' => 'UI/UX Design',      'url' => '/services/ui-ux-design',      'target' => '_self', 'children' => []],
                            ['label' => 'Cloud Solutions',   'url' => '/services/cloud-solutions',   'target' => '_self', 'children' => []],
                        ],
                    ],
                    ['label' => 'Portfolio', 'url' => '/portfolio', 'target' => '_self', 'children' => []],
                    ['label' => 'Blog',      'url' => '/blog',      'target' => '_self', 'children' => []],
                    ['label' => 'Contact',   'url' => '/contact',   'target' => '_self', 'children' => []],
                ],
            ],
            [
                'name' => 'Quick Links',
                'slug' => 'quick-links',
                'items' => [
                    ['label' => 'Home',     'url' => '/',       'target' => '_self', 'children' => []],
                    ['label' => 'About Us', 'url' => '/about',  'target' => '_self', 'children' => []],
                    ['label' => 'Blog',     'url' => '/blog',   'target' => '_self', 'children' => []],
                    ['label' => 'FAQ',      'url' => '/faq',    'target' => '_self', 'children' => []],
                    ['label' => 'Contact',  'url' => '/contact','target' => '_self', 'children' => []],
                ],
            ],
            [
                'name' => 'Services Menu',
                'slug' => 'services-menu',
                'items' => [
                    ['label' => 'Web Development',  'url' => '/services/web-development',  'target' => '_self', 'children' => []],
                    ['label' => 'Digital Marketing', 'url' => '/services/digital-marketing','target' => '_self', 'children' => []],
                    ['label' => 'UI/UX Design',      'url' => '/services/ui-ux-design',     'target' => '_self', 'children' => []],
                    ['label' => 'Cloud Solutions',   'url' => '/services/cloud-solutions',  'target' => '_self', 'children' => []],
                    ['label' => 'Data Analytics',    'url' => '/services/data-analytics',   'target' => '_self', 'children' => []],
                ],
            ],
            [
                'name' => 'Footer Bottom',
                'slug' => 'footer-bottom',
                'items' => [
                    ['label' => 'Privacy Policy',   'url' => '/privacy-policy',   'target' => '_self', 'children' => []],
                    ['label' => 'Terms of Service', 'url' => '/terms-of-service', 'target' => '_self', 'children' => []],
                    ['label' => 'Cookie Policy',    'url' => '/cookie-policy',    'target' => '_self', 'children' => []],
                    ['label' => 'Sitemap',          'url' => '/sitemap',          'target' => '_self', 'children' => []],
                ],
            ],
        ];

        foreach ($menus as $menu) {
            Menu::firstOrCreate(
                ['slug' => $menu['slug']],
                ['name' => $menu['name'], 'items' => $menu['items']]
            );
        }
    }

    // ─── Pages ────────────────────────────────────────────────────────────────

    private function seedPages(): void
    {
        $pages = [
            [
                'title'            => 'About Us',
                'slug'             => 'about',
                'content'          => '<h2>Our Story</h2><p>Unel Solutions was founded in 2015 by a small team of passionate developers and designers who believed that great technology, combined with a deep understanding of business needs, could transform any organisation. Since then, we have grown into a full-service digital agency serving clients across North America, Europe, and the Asia-Pacific region.</p><h2>Our Mission</h2><p>We exist to make advanced digital capabilities accessible to businesses of every size. Whether you are a fast-growing startup or a Fortune 500 enterprise, we bring the same level of dedication, craft, and strategic thinking to every engagement.</p><h2>Our Values</h2><ul><li><strong>Integrity:</strong> We do what we say, and we say what we mean.</li><li><strong>Innovation:</strong> We stay ahead of the curve so our clients do not have to.</li><li><strong>Collaboration:</strong> The best solutions emerge from open dialogue.</li><li><strong>Excellence:</strong> We never ship work we would not be proud to put our name on.</li></ul>',
                'meta_title'       => 'About Unel Solutions – Our Story & Mission',
                'meta_description' => 'Learn about Unel Solutions – a digital agency founded in 2015, helping businesses worldwide achieve digital transformation through web development and strategy.',
                'meta_keywords'    => 'about Unel Solutions, digital agency, web development team, company story',
            ],
            [
                'title'            => 'Contact Us',
                'slug'             => 'contact',
                'content'          => '<h2>Get In Touch</h2><p>We would love to hear about your project. Fill in the form below and one of our team members will respond within one business day.</p><p><strong>Email:</strong> hello@unelsolutions.com<br><strong>Phone:</strong> +1 (800) 555-0199<br><strong>Address:</strong> 250 Innovation Drive, Suite 400, Austin, TX 78701</p><h2>Office Hours</h2><p>Monday – Friday: 9:00 AM – 6:00 PM CST<br>Saturday – Sunday: Closed</p>',
                'meta_title'       => 'Contact Unel Solutions – Let\'s Start a Conversation',
                'meta_description' => 'Reach out to Unel Solutions for web development, digital strategy, and design enquiries. Our team is ready to help you build something great.',
                'meta_keywords'    => 'contact Unel Solutions, web development enquiry, hire digital agency',
            ],
            [
                'title'            => 'FAQ',
                'slug'             => 'faq',
                'content'          => '<h2>Frequently Asked Questions</h2><p>Browse through our most commonly asked questions. Can\'t find what you are looking for? <a href="/contact">Contact us</a> and we will be happy to help.</p>',
                'meta_title'       => 'FAQ – Frequently Asked Questions | Unel Solutions',
                'meta_description' => 'Find answers to common questions about Unel Solutions\' services, pricing, process, and project timelines.',
                'meta_keywords'    => 'FAQ, frequently asked questions, digital agency questions, web development FAQ',
            ],
            [
                'title'            => 'Privacy Policy',
                'slug'             => 'privacy-policy',
                'content'          => '<h2>Privacy Policy</h2><p><em>Last updated: 1 January 2025</em></p><p>Unel Solutions is committed to protecting your personal data and respecting your privacy. This policy explains how we collect, use, disclose, and safeguard your information when you visit our website or engage our services.</p><h3>1. Information We Collect</h3><p>We may collect personally identifiable information such as your name, email address, phone number, and company name when you voluntarily submit it through our contact forms or service enquiries.</p><h3>2. How We Use Your Information</h3><p>We use your information to respond to enquiries, deliver contracted services, send relevant updates (with your consent), and improve our website and offerings.</p><h3>3. Data Retention</h3><p>We retain your data only as long as necessary to fulfil the purposes described in this policy or as required by applicable law.</p><h3>4. Your Rights</h3><p>Depending on your location, you may have the right to access, correct, delete, or restrict processing of your personal data. Contact us at privacy@unelsolutions.com to exercise your rights.</p>',
                'meta_title'       => 'Privacy Policy | Unel Solutions',
                'meta_description' => 'Read Unel Solutions\' Privacy Policy to understand how we collect, use, and protect your personal information.',
                'meta_keywords'    => 'privacy policy, data protection, GDPR, personal data',
            ],
            [
                'title'            => 'Terms of Service',
                'slug'             => 'terms-of-service',
                'content'          => '<h2>Terms of Service</h2><p><em>Last updated: 1 January 2025</em></p><p>These Terms of Service govern your use of the Unel Solutions website and services. By accessing our website or engaging our services you agree to be bound by these terms.</p><h3>1. Services</h3><p>Unel Solutions provides web development, digital strategy, UI/UX design, and related digital services as agreed in individual project contracts or statements of work.</p><h3>2. Intellectual Property</h3><p>All deliverables become the property of the client upon full payment. Unel Solutions retains the right to display the work in its portfolio unless otherwise agreed in writing.</p><h3>3. Limitation of Liability</h3><p>Our liability is limited to the fees paid for the relevant services. We are not liable for indirect, incidental, or consequential damages.</p><h3>4. Governing Law</h3><p>These terms are governed by the laws of the State of Texas, USA.</p>',
                'meta_title'       => 'Terms of Service | Unel Solutions',
                'meta_description' => 'Review the Terms of Service for using Unel Solutions\' website and engaging our digital services.',
                'meta_keywords'    => 'terms of service, terms and conditions, service agreement',
            ],
        ];

        foreach ($pages as $page) {
            Page::firstOrCreate(['slug' => $page['slug']], $page);
        }
    }

    // ─── Slug SEOs ────────────────────────────────────────────────────────────

    private function seedSlugSeos(): void
    {
        $slugSeos = [
            [
                'slug'             => '/',
                'meta_title'       => 'Unel Solutions – Web Development & Digital Strategy',
                'meta_description' => 'Unel Solutions is a full-service digital agency specialising in web development, UI/UX design, and data-driven digital strategy. Let\'s build something great.',
                'meta_keywords'    => ['web development', 'digital agency', 'UI UX design', 'Laravel', 'digital strategy'],
            ],
            [
                'slug'             => '/about',
                'meta_title'       => 'About Unel Solutions – Our Story & Mission',
                'meta_description' => 'Learn about Unel Solutions – a digital agency founded in 2015 helping businesses worldwide achieve digital transformation.',
                'meta_keywords'    => ['about us', 'digital agency team', 'company story', 'Austin Texas'],
            ],
            [
                'slug'             => '/services',
                'meta_title'       => 'Our Services – Web Development, Design & Strategy',
                'meta_description' => 'Explore Unel Solutions\' full range of digital services: web development, digital marketing, UI/UX design, and cloud solutions.',
                'meta_keywords'    => ['web development services', 'digital marketing', 'UI UX design', 'cloud solutions'],
            ],
            [
                'slug'             => '/blog',
                'meta_title'       => 'Blog – Insights on Web Development & Digital Strategy',
                'meta_description' => 'Read the latest articles from the Unel Solutions team on web development, design trends, and digital strategy best practices.',
                'meta_keywords'    => ['web development blog', 'digital strategy articles', 'tech insights'],
            ],
            [
                'slug'             => '/contact',
                'meta_title'       => 'Contact Unel Solutions – Start Your Project Today',
                'meta_description' => 'Get in touch with Unel Solutions. We are ready to discuss your project and show you how we can help you achieve your digital goals.',
                'meta_keywords'    => ['contact us', 'hire web developer', 'digital agency contact'],
            ],
            [
                'slug'             => '/faq',
                'meta_title'       => 'FAQ | Unel Solutions',
                'meta_description' => 'Find answers to common questions about Unel Solutions\' services, pricing, and project process.',
                'meta_keywords'    => ['FAQ', 'frequently asked questions', 'web development pricing'],
            ],
        ];

        foreach ($slugSeos as $seo) {
            SlugSeo::firstOrCreate(
                ['slug' => $seo['slug']],
                [
                    'meta_title'       => $seo['meta_title'],
                    'meta_description' => $seo['meta_description'],
                    'meta_keywords'    => $seo['meta_keywords'],
                ]
            );
        }
    }

    // ─── Blog Categories ──────────────────────────────────────────────────────

    private function seedBlogCategories(): void
    {
        $categories = [
            [
                'name'            => 'Web Development',
                'slug'            => 'web-development',
                'seo_title'       => 'Web Development Articles – Unel Solutions Blog',
                'seo_description' => 'Expert articles on web development, modern frameworks, performance optimisation, and best practices from the Unel Solutions engineering team.',
            ],
            [
                'name'            => 'Digital Marketing',
                'slug'            => 'digital-marketing',
                'seo_title'       => 'Digital Marketing Insights – Unel Solutions Blog',
                'seo_description' => 'Stay ahead of the curve with practical digital marketing guides, SEO tips, and content strategy insights from Unel Solutions.',
            ],
            [
                'name'            => 'UI/UX Design',
                'slug'            => 'ui-ux-design',
                'seo_title'       => 'UI/UX Design Trends & Best Practices – Unel Solutions Blog',
                'seo_description' => 'Discover the latest UI/UX design trends, case studies, and actionable design tips from the Unel Solutions design team.',
            ],
            [
                'name'            => 'Technology News',
                'slug'            => 'technology-news',
                'seo_title'       => 'Technology News & Updates – Unel Solutions Blog',
                'seo_description' => 'Keep up with the latest technology news, platform updates, and industry developments that affect your digital strategy.',
            ],
            [
                'name'            => 'Business Strategy',
                'slug'            => 'business-strategy',
                'seo_title'       => 'Business Strategy & Growth – Unel Solutions Blog',
                'seo_description' => 'Actionable business strategy advice, growth frameworks, and digital transformation insights for modern organisations.',
            ],
        ];

        foreach ($categories as $cat) {
            BlogCategory::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }

    // ─── Blog Posts ───────────────────────────────────────────────────────────

    private function seedBlogPosts(): void
    {
        $categoryMap = BlogCategory::pluck('id', 'slug');

        $posts = [
            [
                'blog_category_id' => $categoryMap['web-development'] ?? 1,
                'title'            => 'Why Laravel Remains the Gold Standard for PHP Web Development in 2025',
                'slug'             => 'laravel-gold-standard-php-2025',
                'excerpt'          => 'With a mature ecosystem, elegant syntax, and a thriving community, Laravel continues to dominate enterprise PHP development. Here is why.',
                'content'          => '<p>Laravel has held its position as the most popular PHP framework for several years running—and 2025 is no different. In this article, we explore the reasons developers and businesses alike continue to choose Laravel for complex, production-grade applications.</p><h2>Expressive Syntax</h2><p>Laravel\'s expressive, fluent API makes common tasks—routing, authentication, queuing, caching—feel natural and readable. This reduces cognitive overhead and allows teams to move faster without sacrificing code quality.</p><h2>Filament: The Admin Panel Revolution</h2><p>One of the biggest reasons teams are choosing Laravel in 2025 is Filament, an incredible TALL-stack admin panel builder that lets you scaffold fully-featured admin dashboards in a fraction of the time. Filament v3 introduced panels, form builders, table builders, and notification systems that feel polished out of the box.</p><h2>First-Class Testing</h2><p>Laravel ships with Pest and PHPUnit support, making it trivial to write expressive, maintainable test suites. The built-in HTTP testing helpers allow you to test your API and web routes end-to-end without spinning up a browser.</p><h2>Conclusion</h2><p>If you are starting a new PHP project in 2025, Laravel should be your first consideration. Its ecosystem, documentation, and community are unmatched.</p>',
                'seo_title'        => 'Why Laravel Is Still the Best PHP Framework in 2025',
                'seo_description'  => 'An in-depth look at why Laravel remains the leading PHP framework in 2025, covering its ecosystem, Filament, and testing capabilities.',
                'seo_keywords'     => 'Laravel 2025, PHP framework, Filament, web development',
                'status'           => 'published',
                'published_at'     => now()->subDays(5)->toDateString(),
            ],
            [
                'blog_category_id' => $categoryMap['web-development'] ?? 1,
                'title'            => 'Building Accessible Web Applications: A Practical Guide for Developers',
                'slug'             => 'building-accessible-web-applications-guide',
                'excerpt'          => 'Accessibility is not an afterthought—it is a fundamental aspect of quality software. Learn how to bake accessibility into your development workflow from day one.',
                'content'          => '<p>Web accessibility (often abbreviated as a11y) ensures that digital products are usable by people with a wide range of abilities. Beyond being the right thing to do, accessible websites rank better in search engines and reach a broader audience.</p><h2>Use Semantic HTML</h2><p>The foundation of accessibility is semantic HTML. Use nav, main, article, and aside elements to give structure to your content. Screen readers rely on these landmarks to help users navigate efficiently.</p><h2>Keyboard Navigation</h2><p>Every interactive element—buttons, links, form fields, modals—must be operable via keyboard. Test your interfaces by unplugging your mouse and navigating with Tab, Enter, and arrow keys.</p><h2>Colour Contrast</h2><p>WCAG 2.1 requires a contrast ratio of at least 4.5:1 for normal text. Use tools like the WebAIM Contrast Checker or the browser\'s built-in accessibility audit to verify your colour choices.</p><h2>ARIA Attributes</h2><p>When native HTML semantics fall short, ARIA attributes fill the gap. Use aria-label, aria-live, and role attributes judiciously—always prefer native HTML elements first.</p>',
                'seo_title'        => 'Web Accessibility Guide for Developers – WCAG Best Practices',
                'seo_description'  => 'A practical guide to building accessible web applications covering semantic HTML, keyboard navigation, colour contrast, and ARIA attributes.',
                'seo_keywords'     => 'web accessibility, a11y, WCAG, semantic HTML, ARIA',
                'status'           => 'published',
                'published_at'     => now()->subDays(12)->toDateString(),
            ],
            [
                'blog_category_id' => $categoryMap['web-development'] ?? 1,
                'title'            => 'Optimising Core Web Vitals: From 65 to 98 in Four Weeks',
                'slug'             => 'optimising-core-web-vitals-case-study',
                'excerpt'          => 'A real-world case study of how our team took a client\'s e-commerce site from a Core Web Vitals score of 65 to 98 in under a month.',
                'content'          => '<p>Core Web Vitals (CWV) are Google\'s set of metrics that measure real-world user experience: Largest Contentful Paint (LCP), Cumulative Layout Shift (CLS), and Interaction to Next Paint (INP). Poor CWV scores directly impact search rankings and conversion rates.</p><h2>The Starting Point</h2><p>Our client, a mid-market e-commerce brand, had an LCP of 4.8 s, a CLS of 0.28, and an INP of 380 ms—all in the "Poor" range. Their organic traffic had declined 18% over six months.</p><h2>Phase 1: Image Optimisation</h2><p>We converted all product images to WebP format, added explicit width/height attributes to every image element to prevent layout shifts, and implemented lazy loading for below-the-fold images.</p><h2>Phase 2: Font Loading Strategy</h2><p>We replaced synchronous font loads with font-display: swap and preloaded the critical font files in the document head. This alone cut LCP by 0.9 seconds.</p><h2>Phase 3: JavaScript Deferral</h2><p>We audited the JS bundle, removed three unused analytics libraries, and deferred all non-critical scripts. The INP dropped from 380 ms to 95 ms after this phase.</p><h2>Results</h2><p>After four weeks of iterative optimisation, the site reached a CWV score of 98. Organic traffic recovered and grew 24% above the pre-decline baseline within two months.</p>',
                'seo_title'        => 'How We Improved Core Web Vitals from 65 to 98 | Case Study',
                'seo_description'  => 'A detailed case study showing how our team optimised LCP, CLS, and INP to take a client\'s Core Web Vitals score from 65 to 98 in four weeks.',
                'seo_keywords'     => 'Core Web Vitals, LCP, CLS, INP, performance optimisation, SEO',
                'status'           => 'published',
                'published_at'     => now()->subDays(20)->toDateString(),
            ],
            [
                'blog_category_id' => $categoryMap['digital-marketing'] ?? 2,
                'title'            => 'The 2025 SEO Playbook: What Still Works and What to Stop Doing',
                'slug'             => 'seo-playbook-2025',
                'excerpt'          => 'Google\'s algorithm has matured. Here is a breakdown of the SEO tactics that deliver results in 2025 and the outdated practices you should drop immediately.',
                'content'          => '<p>Search engine optimisation has changed dramatically over the past five years. With the proliferation of AI-generated content and Google\'s increased reliance on helpful content signals, the tactics that worked in 2020 can actively hurt you in 2025.</p><h2>What Works: E-E-A-T Content</h2><p>Google\'s E-E-A-T framework (Experience, Expertise, Authoritativeness, Trustworthiness) is more important than ever. Content created by genuine subject-matter experts, backed by first-hand experience, consistently outranks generic AI-generated articles.</p><h2>What Works: Programmatic SEO for Long-Tail</h2><p>Intelligently templated content targeting long-tail queries at scale remains one of the highest-ROI SEO strategies. The key is quality and uniqueness—each page must provide genuine value.</p><h2>What to Stop: Keyword Stuffing</h2><p>Over-optimised pages with keyword densities above 2–3% trigger spam signals. Write naturally for humans and let semantic relevance do the heavy lifting.</p><h2>What to Stop: Buying Low-Quality Links</h2><p>Google\'s link spam systems have become exceptionally good at identifying unnatural link patterns. Focus instead on earning links through original research, data journalism, and genuine outreach.</p>',
                'seo_title'        => 'SEO in 2025: Strategies That Work and Mistakes to Avoid',
                'seo_description'  => 'A comprehensive 2025 SEO guide covering E-E-A-T content, programmatic SEO, and the outdated tactics you should stop using immediately.',
                'seo_keywords'     => 'SEO 2025, E-E-A-T, search engine optimisation, content marketing, link building',
                'status'           => 'published',
                'published_at'     => now()->subDays(8)->toDateString(),
            ],
            [
                'blog_category_id' => $categoryMap['ui-ux-design'] ?? 3,
                'title'            => 'Designing for Delight: The Psychology Behind Great User Interfaces',
                'slug'             => 'psychology-behind-great-user-interfaces',
                'excerpt'          => 'The best interfaces feel invisible. Understanding the psychology of perception, attention, and emotion helps designers build products people love.',
                'content'          => '<p>Great UI design is invisible. When an interface works beautifully, users do not notice the design—they simply achieve their goals. Understanding the psychological principles that govern how humans perceive and interact with interfaces is the foundation of truly exceptional UX.</p><h2>Hick\'s Law: Reduce Decision Fatigue</h2><p>The more choices a user faces, the longer it takes them to decide. Hick\'s Law tells us to limit options at each decision point. Instead of showing all features upfront, progressive disclosure reveals complexity only when the user needs it.</p><h2>The Serial Position Effect</h2><p>Users remember items at the beginning and end of a list far better than items in the middle. In navigation design, this means placing the most critical actions at the start and end of your menu.</p><h2>Colour Psychology</h2><p>Colour is one of the most powerful tools in a designer\'s arsenal. Blue builds trust. Orange creates urgency. Green signals safety and progress. Understanding these associations allows designers to guide user emotion and behaviour.</p><h2>Microinteractions</h2><p>Small animations—a button that bounces on click, a form field that shakes on error, a progress indicator that fills smoothly—provide immediate feedback and make an interface feel responsive and alive.</p>',
                'seo_title'        => 'The Psychology of Great UI Design – Hick\'s Law, Colour & More',
                'seo_description'  => 'Explore the psychological principles behind exceptional UI design, including Hick\'s Law, the serial position effect, colour psychology, and microinteractions.',
                'seo_keywords'     => 'UI design psychology, UX design principles, Hick\'s Law, colour psychology, microinteractions',
                'status'           => 'published',
                'published_at'     => now()->subDays(15)->toDateString(),
            ],
            [
                'blog_category_id' => $categoryMap['technology-news'] ?? 4,
                'title'            => 'PHP 8.4 Arrives: What the New Features Mean for Your Laravel Projects',
                'slug'             => 'php-8-4-features-laravel-impact',
                'excerpt'          => 'PHP 8.4 is here with property hooks, asymmetric visibility, and a new HTML5-compliant parser. Here is a practical look at what the release means for Laravel developers.',
                'content'          => '<p>PHP 8.4 was released on 21 November 2024, and it brings a host of quality-of-life improvements that will change how Laravel developers write and read code on a daily basis.</p><h2>Property Hooks</h2><p>The headline feature of PHP 8.4, property hooks allow you to attach get and set logic directly to class properties, eliminating the need for boilerplate getter/setter methods in many common scenarios.</p><h2>Asymmetric Visibility</h2><p>You can now define different access levels for reading and writing a property. For example, a property that is publicly readable but only writable within the class itself—a pattern that was previously only achievable with read-only properties or manual accessors.</p><h2>New Array Functions</h2><p>PHP 8.4 adds array_find(), array_find_key(), array_any(), and array_all(), reducing the need for verbose array_filter() and array_map() combinations.</p><h2>Impact on Laravel</h2><p>Laravel 11 and 12 fully support PHP 8.4. Property hooks are particularly useful in Eloquent model accessors and value objects, and the new array functions simplify collection-heavy code.</p>',
                'seo_title'        => 'PHP 8.4 Features & What They Mean for Laravel Developers',
                'seo_description'  => 'A practical breakdown of PHP 8.4\'s property hooks, asymmetric visibility, and new array functions, and how they impact Laravel development.',
                'seo_keywords'     => 'PHP 8.4, PHP features, Laravel, property hooks, asymmetric visibility',
                'status'           => 'published',
                'published_at'     => now()->subDays(30)->toDateString(),
            ],
            [
                'blog_category_id' => $categoryMap['business-strategy'] ?? 5,
                'title'            => 'Digital Transformation in 2025: A Roadmap for Mid-Market Companies',
                'slug'             => 'digital-transformation-roadmap-mid-market-2025',
                'excerpt'          => 'Digital transformation is not a technology project—it is a business strategy. Here is a practical roadmap for mid-market companies ready to modernise their operations.',
                'content'          => '<p>Digital transformation has become one of the most overused phrases in business, yet its importance is undeniable. For mid-market companies—those with revenues between $10M and $1B—the stakes are particularly high.</p><h2>Phase 1: Audit Your Current State</h2><p>Before spending a dollar on new technology, document your existing processes, systems, and pain points. Where are your biggest bottlenecks? Which manual processes could be automated? Where is data siloed?</p><h2>Phase 2: Define Your Digital North Star</h2><p>Choose two or three business outcomes—not technology features—as your guiding objectives. "Reduce order processing time by 40%" is a business outcome. "Implement an ERP" is a technology project. Your North Star keeps the transformation grounded in value.</p><h2>Phase 3: Build in Iterations</h2><p>Avoid the "big bang" transformation. Instead, identify quick wins (90-day cycles) that deliver measurable value while building momentum and stakeholder confidence.</p><h2>Phase 4: Invest in Change Management</h2><p>The technology is rarely the hard part. Winning hearts and minds across the organisation—from frontline staff to the C-suite—is what determines success or failure.</p>',
                'seo_title'        => 'Digital Transformation Roadmap for Mid-Market Companies 2025',
                'seo_description'  => 'A practical, phase-by-phase digital transformation roadmap for mid-market companies, covering auditing, goal-setting, iterative delivery, and change management.',
                'seo_keywords'     => 'digital transformation, mid-market, business strategy, IT modernisation, change management',
                'status'           => 'published',
                'published_at'     => now()->subDays(25)->toDateString(),
            ],
            [
                'blog_category_id' => $categoryMap['web-development'] ?? 1,
                'title'            => 'Getting Started with Inertia.js and Laravel: A Complete Guide',
                'slug'             => 'inertia-js-laravel-complete-guide',
                'excerpt'          => 'Inertia.js bridges the gap between classic server-side rendering and modern SPAs. This guide walks you through setting up Inertia with Laravel and React.',
                'content'          => '<p>Inertia.js is a protocol and client-side adapter that lets you build single-page application experiences using classic server-side routing and controllers. It eliminates the need for a dedicated API layer, making it a compelling choice for teams building with Laravel.</p><h2>Why Inertia?</h2><p>Traditional SPAs require a separate API, token authentication, CORS configuration, and a client-side routing library. Inertia removes all of that. Your Laravel routes and controllers handle everything; Inertia\'s adapter renders the corresponding React or Vue component client-side.</p><h2>Installation</h2><p>Install the server-side adapter: composer require inertiajs/inertia-laravel. Install the client-side adapter: npm install @inertiajs/react. Configure your root Blade template and app.js entry point, and you are ready to return Inertia responses from your controllers.</p>',
                'seo_title'        => 'Inertia.js + Laravel: The Complete 2025 Setup Guide',
                'seo_description'  => 'Learn how to build SPA-like experiences with Inertia.js and Laravel without a separate API, covering installation, routing, and data sharing.',
                'seo_keywords'     => 'Inertia.js, Laravel, SPA, React, Vue, full-stack JavaScript',
                'status'           => 'draft',
                'published_at'     => null,
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::firstOrCreate(['slug' => $post['slug']], $post);
        }
    }

    // ─── FAQs ─────────────────────────────────────────────────────────────────

    private function seedFaqs(): void
    {
        $faqs = [
            ['question' => 'What services does Unel Solutions offer?',                  'answer' => 'We offer a comprehensive range of digital services including custom web development (Laravel, React, Vue), UI/UX design, digital marketing, SEO, content management system setup, cloud infrastructure, and ongoing maintenance and support.',          'is_active' => true, 'sort_order' => 1],
            ['question' => 'How long does a typical web development project take?',     'answer' => 'Project timelines vary depending on scope and complexity. A simple brochure website typically takes 4–6 weeks, while a complex web application or e-commerce platform may take 3–6 months. We provide a detailed timeline during our discovery phase before any work begins.', 'is_active' => true, 'sort_order' => 2],
            ['question' => 'Do you provide ongoing support after project launch?',      'answer' => 'Yes. We offer flexible support and maintenance packages ranging from basic security updates and backups to comprehensive packages that include feature development, performance monitoring, and dedicated account management. We can tailor a plan to your specific needs.',      'is_active' => true, 'sort_order' => 3],
            ['question' => 'What technologies do you specialise in?',                   'answer' => 'Our core stack includes Laravel (PHP), React, Vue.js, and Filament for CMS-driven projects. On the infrastructure side we work with AWS, DigitalOcean, and Cloudflare. We are always evaluating emerging technologies to ensure we recommend the right tool for each job.',     'is_active' => true, 'sort_order' => 4],
            ['question' => 'How do you handle project pricing?',                        'answer' => 'We offer both fixed-price and time-and-materials engagements. For well-defined projects, a fixed-price quote provides cost certainty. For exploratory or evolving projects, time-and-materials offers greater flexibility. We will recommend the most appropriate model after understanding your requirements.',   'is_active' => true, 'sort_order' => 5],
            ['question' => 'Can you work with our existing design or do you handle design as well?', 'answer' => 'Both. We are happy to implement designs provided by your in-house team or a third-party agency. Alternatively, our in-house design team can take your project from wireframe to high-fidelity prototype. In either case, we ensure the final build is pixel-perfect and fully accessible.', 'is_active' => true, 'sort_order' => 6],
            ['question' => 'Do you build mobile applications?',                         'answer' => 'We specialise in responsive web applications that work beautifully across all device sizes. For native mobile apps (iOS and Android), we partner with trusted mobile development studios and can coordinate the full project on your behalf.',                                     'is_active' => true, 'sort_order' => 7],
            ['question' => 'How do we get started?',                                    'answer' => 'Simply reach out through our contact form or email hello@unelsolutions.com. We will schedule a free 30-minute discovery call to understand your goals, answer your questions, and outline how we can help. There is no obligation—just a conversation.',                           'is_active' => true, 'sort_order' => 8],
            ['question' => 'Is my website data secure?',                                'answer' => 'Security is built into every layer of our development process. We follow OWASP guidelines, implement proper authentication and authorisation, use HTTPS everywhere, perform regular dependency audits, and conduct security reviews before every major release.',                  'is_active' => true, 'sort_order' => 9],
            ['question' => 'Do you work with clients outside the United States?',       'answer' => 'Absolutely. We have delivered projects for clients across North America, Europe, the Middle East, and Asia-Pacific. Our team works across time zones and we have well-established processes for remote collaboration, including asynchronous communication and shared project management tooling.', 'is_active' => true, 'sort_order' => 10],
        ];

        foreach ($faqs as $faq) {
            Faq::firstOrCreate(['question' => $faq['question']], $faq);
        }
    }

    // ─── Testimonials ─────────────────────────────────────────────────────────

    private function seedTestimonials(): void
    {
        $testimonials = [
            [
                'client_name'        => 'Apex Retail Group',
                'slug'               => 'apex-retail-group',
                'quote'              => 'Unel Solutions completely transformed our online presence. Our e-commerce conversion rate increased by 42% in the first quarter after launch, and the platform has handled our peak sale events without a single issue.',
                'author_name'        => 'Sarah Mitchell',
                'author_role'        => 'Chief Digital Officer',
                'is_featured'        => true,
                'sort_order'         => 1,
                'is_published'       => true,
                'region'             => 'North America',
                'industry'           => 'Retail & E-Commerce',
                'client_description' => 'Mid-market specialty retailer with 120+ stores and a rapidly growing online channel.',
                'project_type'       => 'E-Commerce Platform Rebuild',
                'project_description' => 'We migrated Apex\'s existing Magento 1 store to a custom Laravel + Vue.js solution integrated with their ERP and warehouse management system, reducing page load times by 68% and enabling real-time inventory sync across all channels.',
                'primary_location'   => 'Austin, Texas, USA',
                'location_description' => 'Operations in 12 US states with fulfilment centres across the country.',
                'services_scope'     => 'Web Development, Systems Integration, Performance Optimisation',
                'services_description' => 'Custom Laravel backend, Vue.js storefront, REST API development, ERP integration, CI/CD pipeline setup.',
                'verification_type'  => 'Signed Reference Letter',
                'verification_description' => 'Letter provided by CDO on company letterhead.',
                'full_letter'        => 'To whom it may concern, it is my pleasure to recommend Unel Solutions for their exceptional work on our e-commerce platform rebuild. The project was delivered on time and to a very high standard. Sarah Mitchell, Chief Digital Officer, Apex Retail Group.',
                'meta_title'         => 'Apex Retail Group Case Study – E-Commerce Platform Rebuild | Unel Solutions',
                'meta_description'   => 'See how Unel Solutions helped Apex Retail Group increase e-commerce conversions by 42% through a custom Laravel and Vue.js platform rebuild.',
                'video_url'          => null,
                'case_study_content' => '<h2>The Challenge</h2><p>Apex Retail Group was running a decade-old Magento 1 installation that had become a bottleneck. Page load times averaged 6.2 seconds on mobile, the admin panel required specialist developers for even minor changes, and integrating with their modern ERP was prohibitively complex.</p><h2>Our Approach</h2><p>We began with a thorough discovery phase, mapping every integration point and business rule. We designed a headless architecture with a Laravel API backend, a Vue.js storefront, and a Filament-powered CMS that non-technical staff could operate confidently.</p><h2>Results</h2><ul><li>Page load time reduced from 6.2 s to 1.9 s</li><li>Conversion rate increased 42% in Q1 post-launch</li><li>Zero downtime during Black Friday (3x normal traffic)</li><li>Admin content tasks reduced from hours to minutes</li></ul>',
            ],
            [
                'client_name'        => 'Horizon Financial Services',
                'slug'               => 'horizon-financial-services',
                'quote'              => 'The team delivered a complex, regulation-compliant client portal on time and within budget. Their attention to security and their transparent communication throughout the project gave us complete confidence.',
                'author_name'        => 'David Okafor',
                'author_role'        => 'Head of Technology',
                'is_featured'        => true,
                'sort_order'         => 2,
                'is_published'       => true,
                'region'             => 'Europe',
                'industry'           => 'Financial Services',
                'client_description' => 'Independent wealth management firm managing AUM of £2.4 billion.',
                'project_type'       => 'Secure Client Portal Development',
                'project_description' => 'We built a secure client portal enabling Horizon\'s advisors to share sensitive documents, communicate with clients, and manage task workflows—all within a fully audited, FCA-compliant environment.',
                'primary_location'   => 'London, United Kingdom',
                'location_description' => 'UK headquarters, serving clients across the UK and EU.',
                'services_scope'     => 'Web Application Development, Security Architecture, Compliance Consulting',
                'services_description' => 'Laravel backend, React frontend, E2E encryption, MFA, role-based access control, audit logging.',
                'verification_type'  => 'Video Testimonial',
                'verification_description' => 'Short-form video recorded at client headquarters.',
                'full_letter'        => 'Unel Solutions delivered an exceptional secure portal for our wealth management firm. Their professionalism, attention to compliance requirements, and technical quality exceeded our expectations. David Okafor, Head of Technology, Horizon Financial Services.',
                'meta_title'         => 'Horizon Financial Services Case Study – Secure Client Portal | Unel Solutions',
                'meta_description'   => 'How Unel Solutions built a secure, FCA-compliant client portal for Horizon Financial Services, enabling safe document sharing and advisor-client communication.',
                'video_url'          => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'case_study_content' => '<h2>The Challenge</h2><p>Horizon Financial Services was sharing sensitive client documents via unencrypted email—a serious regulatory and reputational risk. They needed a purpose-built portal that met FCA requirements and was intuitive enough for their high-net-worth clients to use without training.</p><h2>Our Approach</h2><p>Security was designed into the architecture from day one. We implemented AES-256 encryption at rest, TLS 1.3 in transit, and TOTP-based multi-factor authentication. Role-based access control ensured clients could only ever see their own data. Every action in the system was logged to an immutable audit trail.</p><h2>Results</h2><ul><li>100% of document sharing moved off email within 60 days of launch</li><li>Client onboarding time reduced from 3 days to 4 hours</li><li>Zero security incidents since deployment</li><li>Passed independent FCA compliance audit on first attempt</li></ul>',
            ],
            [
                'client_name'        => 'GreenPath Logistics',
                'slug'               => 'greenpath-logistics',
                'quote'              => 'We asked for a marketing site relaunch and got back something that genuinely represents who we are. The design is beautiful, the CMS is incredibly easy to use, and our SEO rankings have climbed consistently since launch.',
                'author_name'        => 'Priya Sharma',
                'author_role'        => 'Marketing Director',
                'is_featured'        => false,
                'sort_order'         => 3,
                'is_published'       => true,
                'region'             => 'Asia Pacific',
                'industry'           => 'Logistics & Supply Chain',
                'client_description' => 'Regional third-party logistics provider operating across 8 Asia-Pacific countries.',
                'project_type'       => 'Marketing Website Design & Development',
                'project_description' => 'Complete redesign and redevelopment of GreenPath\'s corporate website, including a Filament-powered CMS, multilingual support, and an SEO-optimised content architecture.',
                'primary_location'   => 'Singapore',
                'location_description' => 'Operations across Singapore, Australia, Japan, South Korea, and four additional APAC markets.',
                'services_scope'     => 'Web Design, CMS Development, SEO',
                'services_description' => 'UI/UX design, Laravel development, Filament CMS, on-page SEO, multilingual support.',
                'verification_type'  => 'Written Testimonial',
                'verification_description' => 'Written review submitted by Marketing Director.',
                'full_letter'        => 'Working with Unel Solutions was a transformative experience for GreenPath. They delivered a world-class website and content management system that our team can manage independently. Priya Sharma, Marketing Director, GreenPath Logistics.',
                'meta_title'         => 'GreenPath Logistics Case Study – Marketing Website Redesign | Unel Solutions',
                'meta_description'   => 'How Unel Solutions designed and built a modern, SEO-optimised marketing website for GreenPath Logistics, supporting their Asia-Pacific expansion.',
                'video_url'          => null,
                'case_study_content' => '<h2>The Challenge</h2><p>GreenPath\'s website was outdated, difficult to update, and invisible in search results. With a regional expansion planned, they needed a credible digital presence that could grow with them.</p><h2>Our Approach</h2><p>We conducted stakeholder interviews and competitor analysis before entering the design phase. The resulting design system prioritised clarity, speed, and trust signals—crucial in the logistics sector. We built the site on Laravel with a Filament CMS so the marketing team could publish content independently.</p><h2>Results</h2><ul><li>Organic search traffic increased 185% in 6 months</li><li>Time-on-site increased 67%</li><li>Marketing team now publishes 3x more content per month</li><li>Website featured in two industry publications as a design example</li></ul>',
            ],
            [
                'client_name'        => 'Catalyst EdTech',
                'slug'               => 'catalyst-edtech',
                'quote'              => 'Unel Solutions built our learning platform from scratch in just 14 weeks. The product quality, speed of delivery, and their genuine enthusiasm for our mission made them an exceptional partner.',
                'author_name'        => 'Marcus Williams',
                'author_role'        => 'Co-Founder & CEO',
                'is_featured'        => true,
                'sort_order'         => 4,
                'is_published'       => true,
                'region'             => 'North America',
                'industry'           => 'Education Technology',
                'client_description' => 'Venture-backed EdTech startup providing adaptive learning tools for K-12 institutions.',
                'project_type'       => 'SaaS Platform MVP Development',
                'project_description' => 'We designed and built Catalyst\'s adaptive learning platform from zero—including student dashboards, teacher admin tools, progress analytics, and a content builder—in 14 weeks.',
                'primary_location'   => 'Boston, Massachusetts, USA',
                'location_description' => 'Remote-first US team based out of Boston, Massachusetts.',
                'services_scope'     => 'Product Design, Web Development, DevOps',
                'services_description' => 'UX research, wireframing, UI design, Laravel API, React frontend, PostgreSQL, CI/CD, AWS deployment.',
                'verification_type'  => 'Video Testimonial',
                'verification_description' => 'Long-form video interview with co-founder.',
                'full_letter'        => 'I cannot recommend Unel Solutions highly enough. They took our concept from zero to a fully working product in 14 weeks and the quality of the software was indistinguishable from teams 5x their size. Marcus Williams, Co-Founder & CEO, Catalyst EdTech.',
                'meta_title'         => 'Catalyst EdTech Case Study – Learning Platform MVP | Unel Solutions',
                'meta_description'   => 'How Unel Solutions designed and built Catalyst EdTech\'s adaptive learning platform MVP in 14 weeks, from zero to production.',
                'video_url'          => null,
                'case_study_content' => '<h2>The Challenge</h2><p>Catalyst EdTech had secured seed funding and needed to get a working product in front of pilot schools within four months. Their founding team had domain expertise but no engineering capacity. They needed a trusted partner who could own the technical delivery end-to-end.</p><h2>Our Approach</h2><p>We embedded a dedicated team of two developers, one designer, and a part-time product manager. We ran two-week sprints with weekly demos to the founders. By week 6 we had a working alpha; by week 14 the platform was deployed to AWS and three pilot schools were onboarded.</p><h2>Results</h2><ul><li>MVP delivered in 14 weeks, on time and on budget</li><li>Three pilot schools onboarded within 2 weeks of launch</li><li>Platform achieved 98.9% uptime in first 90 days</li><li>Catalyst raised a Series A round citing the platform quality as a key investor confidence factor</li></ul>',
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::firstOrCreate(['slug' => $testimonial['slug']], $testimonial);
        }
    }

    // ─── Contact Inquiries ────────────────────────────────────────────────────

    private function seedContactInquiries(): void
    {
        $inquiries = [
            ['name' => 'James Thornton',   'email' => 'james.thornton@thorntonretail.com',  'phone' => '+1 512 555 0174',  'service' => 'E-Commerce Development',         'message' => 'Hi, we are looking to rebuild our Shopify store on a custom platform that integrates with our Sage ERP. We have around 15,000 SKUs and roughly $8M in annual online revenue. Could you please share whether this is within your scope and an indicative timeline?',         'status' => 'new',      'read_at' => null],
            ['name' => 'Amelia Foster',    'email' => 'afoster@horizonwealth.co.uk',         'phone' => '+44 20 7946 0958', 'service' => 'Web Application Development',     'message' => 'Hello, I am the Head of Digital at Horizon Wealth. We need a secure document-sharing portal for our clients. Data security and FCA compliance are non-negotiable. Would love to arrange a call this week.',                                                              'status' => 'read',     'read_at' => now()->subDays(2)],
            ['name' => 'Carlos Mendes',    'email' => 'c.mendes@greenpath-logistics.sg',     'phone' => '+65 6555 0139',    'service' => 'Digital Marketing & SEO',          'message' => 'We are a logistics company based in Singapore and we want to improve our organic search visibility across APAC. Our current website barely ranks for any of our target keywords. Looking for a partner who understands B2B SEO.',                                             'status' => 'replied',  'read_at' => now()->subDays(5)],
            ['name' => 'Nadia Petrov',     'email' => 'n.petrov@techwave.eu',                'phone' => null,               'service' => 'UI/UX Design',                     'message' => 'We have a web application that was built 4 years ago and the UX is terrible. We want to redesign the entire user experience without rewriting the backend. Is this something you can help with? We are based in Berlin.',                                                       'status' => 'new',      'read_at' => null],
            ['name' => 'Oliver Huang',     'email' => 'oliverh@catalystedtech.com',          'phone' => '+1 617 555 0222',  'service' => 'SaaS Development',                 'message' => 'I am a co-founder at an EdTech startup. We have a validated concept and seed funding, and we need to build our MVP. Looking for a team that can move fast and communicate clearly. We need to launch in about 3 months.',                                                    'status' => 'archived', 'read_at' => now()->subDays(14)],
            ['name' => 'Rachel Kim',       'email' => 'rachel@blossom-wellness.com',         'phone' => '+1 213 555 0187',  'service' => 'Website Design & Development',     'message' => 'We are a wellness brand launching a new online store and blog. We want something beautiful and fast. Budget is around $25,000-$35,000. Can you share some relevant examples from your portfolio?',                                                                              'status' => 'new',      'read_at' => null],
            ['name' => 'Tom Harrington',   'email' => 'tom.harrington@claritylegal.com',     'phone' => '+1 646 555 0109',  'service' => 'Web Development',                  'message' => 'We are a law firm in New York and our current website is embarrassingly outdated. We need a professional redesign and a CMS we can actually use without calling our developer for every change. Do you work with professional services firms?',                                  'status' => 'read',     'read_at' => now()->subDays(1)],
            ['name' => 'Fatima Al-Rashidi','email' => 'fatima@innovate-me.ae',               'phone' => '+971 4 555 0148',  'service' => 'Digital Strategy',                 'message' => 'We are looking for a partner who can help us build a comprehensive digital strategy for entering the GCC market. We are a fintech startup from Europe. Would like to explore how you approach market entry projects.',                                                           'status' => 'new',      'read_at' => null],
        ];

        foreach ($inquiries as $inquiry) {
            ContactInquiry::firstOrCreate(
                ['email' => $inquiry['email'], 'message' => $inquiry['message']],
                $inquiry
            );
        }
    }

    // ─── Redirects ────────────────────────────────────────────────────────────

    private function seedRedirects(): void
    {
        $redirects = [
            ['old_url' => '/home',                            'new_url' => '/',                                       'status_code' => 301, 'is_active' => true],
            ['old_url' => '/our-services',                    'new_url' => '/services',                               'status_code' => 301, 'is_active' => true],
            ['old_url' => '/services/development',            'new_url' => '/services/web-development',               'status_code' => 301, 'is_active' => true],
            ['old_url' => '/news',                            'new_url' => '/blog',                                   'status_code' => 301, 'is_active' => true],
            ['old_url' => '/company',                         'new_url' => '/about',                                  'status_code' => 301, 'is_active' => true],
            ['old_url' => '/get-in-touch',                    'new_url' => '/contact',                                'status_code' => 301, 'is_active' => true],
            ['old_url' => '/blog/laravel-gold-standard-php-2024', 'new_url' => '/blog/laravel-gold-standard-php-2025','status_code' => 301, 'is_active' => true],
            ['old_url' => '/terms',                           'new_url' => '/terms-of-service',                       'status_code' => 301, 'is_active' => true],
            ['old_url' => '/privacy',                         'new_url' => '/privacy-policy',                         'status_code' => 301, 'is_active' => true],
            ['old_url' => '/work',                            'new_url' => '/portfolio',                              'status_code' => 301, 'is_active' => true],
            ['old_url' => '/old-landing-page',                'new_url' => '/',                                       'status_code' => 302, 'is_active' => false],
        ];

        foreach ($redirects as $redirect) {
            Redirect::firstOrCreate(['old_url' => $redirect['old_url']], $redirect);
        }
    }
}
