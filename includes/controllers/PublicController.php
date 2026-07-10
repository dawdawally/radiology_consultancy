<?php

declare(strict_types=1);

class PublicController
{
    private HomepageModel $homepage;
    private AboutModel $about;
    private ServiceModel $services;
    private EquipmentModel $equipment;
    private BlogModel $blog;
    private TestimonialModel $testimonials;
    private MessageModel $messages;

    public function __construct()
    {
        $this->homepage = new HomepageModel();
        $this->about = new AboutModel();
        $this->services = new ServiceModel();
        $this->equipment = new EquipmentModel();
        $this->blog = new BlogModel();
        $this->testimonials = new TestimonialModel();
        $this->messages = new MessageModel();
    }

    public function dispatch(string $route): void
    {
        $parts = explode('/', $route);
        $page = $parts[0] ?: 'home';

        try {
            match ($page) {
                'home', '' => $this->home(),
                'about' => $this->aboutPage(),
                'services' => $this->servicesPage($parts[1] ?? null),
                'equipment' => $this->equipmentPage(),
                'blog' => $this->blogPage($parts[1] ?? null),
                'testimonials' => $this->testimonialsPage(),
                'contact' => $this->contactPage(),
                'privacy' => $this->legalPage('privacy'),
                'terms' => $this->legalPage('terms'),
                default => $this->notFound(),
            };
        } catch (PDOException $e) {
            if (config('debug')) {
                die('Database error: ' . e($e->getMessage()) . '. Run database/install.php first.');
            }
            $this->notFound();
        }
    }

    private function home(): void
    {
        render('home', [
            'pageTitle' => getSeo('home')['meta_title'] ?? getSetting('site_name'),
            'metaDescription' => getSeo('home')['meta_description'] ?? getSetting('tagline'),
            'sections' => $this->homepage->getActiveSections(),
            'services' => array_slice($this->services->getPublished(), 0, 6),
            'equipment' => $this->equipment->getPublishedGrouped(),
            'testimonials' => array_slice($this->testimonials->getPublished(), 0, 3),
            'posts' => $this->blog->getPublished(3),
        ]);
    }

    private function aboutPage(): void
    {
        render('about', [
            'pageTitle' => getSeo('about')['meta_title'] ?? 'About Us',
            'metaDescription' => getSeo('about')['meta_description'] ?? '',
            'sections' => $this->about->getSections(),
        ]);
    }

    private function servicesPage(?string $slug): void
    {
        if ($slug) {
            $service = $this->services->findBySlug($slug);
            if (!$service) {
                $this->notFound();
                return;
            }
            render('service-detail', [
                'pageTitle' => $service['meta_title'] ?? $service['title'],
                'metaDescription' => $service['meta_description'] ?? $service['short_description'],
                'service' => $service,
            ]);
            return;
        }

        render('services', [
            'pageTitle' => getSeo('services')['meta_title'] ?? 'Our Services',
            'metaDescription' => getSeo('services')['meta_description'] ?? '',
            'services' => $this->services->getPublished(),
        ]);
    }

    private function equipmentPage(): void
    {
        render('equipment', [
            'pageTitle' => getSeo('equipment')['meta_title'] ?? 'Equipment Expertise',
            'metaDescription' => getSeo('equipment')['meta_description'] ?? '',
            'equipment' => $this->equipment->getPublishedGrouped(),
        ]);
    }

    private function blogPage(?string $slug): void
    {
        if ($slug) {
            $post = $this->blog->findBySlug($slug);
            if (!$post) {
                $this->notFound();
                return;
            }
            render('blog-detail', [
                'pageTitle' => $post['meta_title'] ?? $post['title'],
                'metaDescription' => $post['meta_description'] ?? $post['excerpt'],
                'post' => $post,
            ]);
            return;
        }

        render('blog', [
            'pageTitle' => getSeo('blog')['meta_title'] ?? 'Resources & Insights',
            'metaDescription' => getSeo('blog')['meta_description'] ?? '',
            'posts' => $this->blog->getPublished(),
        ]);
    }

    private function testimonialsPage(): void
    {
        render('testimonials', [
            'pageTitle' => 'Case Studies & Testimonials',
            'metaDescription' => 'Client success stories from radiation equipment projects worldwide.',
            'testimonials' => $this->testimonials->getPublished(),
        ]);
    }

    private function contactPage(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleContact();
            return;
        }

        render('contact', [
            'pageTitle' => getSeo('contact')['meta_title'] ?? 'Contact Us',
            'metaDescription' => getSeo('contact')['meta_description'] ?? '',
        ]);
    }

    private function handleContact(): void
    {
        if (!verifyCsrf($_POST['csrf_token'] ?? '')) {
            setFlash('danger', 'Invalid request. Please try again.');
            redirect(url('contact'));
        }

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'subject' => trim($_POST['subject'] ?? ''),
            'message' => trim($_POST['message'] ?? ''),
        ];

        storeOldInput($data);

        if ($data['name'] === '' || $data['email'] === '' || $data['message'] === '') {
            setFlash('danger', 'Please fill in all required fields.');
            redirect(url('contact'));
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            setFlash('danger', 'Please enter a valid email address.');
            redirect(url('contact'));
        }

        $this->messages->create($data);
        clearOldInput();

        $adminEmail = config('mail.admin_email');
        $subject = 'New Contact: ' . ($data['subject'] ?: 'Consultation Request');
        $body = "Name: {$data['name']}\nEmail: {$data['email']}\nPhone: {$data['phone']}\n\n{$data['message']}";
        @mail($adminEmail, $subject, $body, 'From: ' . config('mail.from_email'));

        setFlash('success', getSetting('response_time', 'We respond to all inquiries within 24 hours.'));
        redirect(url('contact'));
    }

    private function legalPage(string $type): void
    {
        $key = $type . '_content';
        render('legal', [
            'pageTitle' => ucfirst($type) . ' Policy',
            'metaDescription' => getSeo($type)['meta_description'] ?? '',
            'title' => ucfirst($type) . ' Policy',
            'content' => getSetting($key),
        ]);
    }

    private function notFound(): void
    {
        http_response_code(404);
        render('404', [
            'pageTitle' => 'Page Not Found',
            'metaDescription' => '',
        ]);
    }
}
