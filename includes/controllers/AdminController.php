<?php

declare(strict_types=1);

class AdminController
{
    public function dispatch(string $page, string $action = 'index'): void
    {
        requireAuth();

        match ($page) {
            'dashboard', '' => $this->dashboard(),
            'homepage' => $this->homepage($action),
            'about' => $this->about($action),
            'services' => $this->services($action),
            'equipment' => $this->equipment($action),
            'blog' => $this->blog($action),
            'testimonials' => $this->testimonials($action),
            'faq' => $this->faq($action),
            'messages' => $this->messages($action),
            'seo' => $this->seo($action),
            'settings' => $this->settings($action),
            'media' => $this->media($action),
            'profile' => $this->profile($action),
            default => $this->dashboard(),
        };
    }

    private function dashboard(): void
    {
        $messages = new MessageModel();
        $blog = new BlogModel();
        $services = new ServiceModel();

        renderAdmin('dashboard', [
            'pageHeading' => 'Dashboard',
            'unreadMessages' => $messages->getUnreadCount(),
            'recentMessages' => $messages->getRecent(5),
            'totalServices' => $services->count(),
            'totalPosts' => $blog->count(),
        ]);
    }

    private function homepage(string $action): void
    {
        $model = new HomepageModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'save') {
            $this->requireCsrf();
            $key = $_POST['section_key'] ?? '';
            $model->updateSection($key, [
                'title' => $_POST['title'] ?? '',
                'subtitle' => $_POST['subtitle'] ?? '',
                'content' => $_POST['content'] ?? '',
                'button_text' => $_POST['button_text'] ?? '',
                'button_url' => $_POST['button_url'] ?? '',
                'extra_data' => $_POST['extra_data'] ?? null,
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
            ]);
            logActivity('update', 'homepage', null, "Updated section: {$key}");
            setFlash('success', 'Homepage section updated.');
            redirect(adminUrl('page=homepage&edit=' . urlencode($key)));
        }

        $sections = $model->findAll('sort_order ASC');
        $editKey = $_GET['edit'] ?? ($sections[0]['section_key'] ?? null);
        $editSection = $editKey ? $model->getByKey($editKey) : null;

        renderAdmin('homepage', [
            'pageHeading' => 'Homepage Manager',
            'sections' => $sections,
            'editSection' => $editSection,
        ]);
    }

    private function about(string $action): void
    {
        $model = new AboutModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'save') {
            $this->requireCsrf();
            $key = $_POST['section_key'] ?? '';
            $model->updateSection($key, [
                'title' => $_POST['title'] ?? '',
                'content' => $_POST['content'] ?? '',
            ]);
            logActivity('update', 'about', null, "Updated section: {$key}");
            setFlash('success', 'About section updated.');
            redirect(adminUrl('page=about&edit=' . urlencode($key)));
        }

        $sections = $model->findAll('sort_order ASC');
        $editKey = $_GET['edit'] ?? ($sections[0]['section_key'] ?? null);
        $editSection = null;
        if ($editKey) {
            $all = $model->getSections();
            $editSection = $all[$editKey] ?? null;
        }

        renderAdmin('about', [
            'pageHeading' => 'About Manager',
            'sections' => $sections,
            'editSection' => $editSection,
        ]);
    }

    private function services(string $action): void
    {
        $model = new ServiceModel();

        if ($action === 'delete' && isset($_GET['id'])) {
            $this->requireCsrfGet();
            $model->delete((int) $_GET['id']);
            logActivity('delete', 'services', (int) $_GET['id'], 'Deleted service');
            setFlash('success', 'Service deleted.');
            redirect(adminUrl('page=services'));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->requireCsrf();
            $data = $this->serviceDataFromPost();
            if ($action === 'create') {
                $id = $model->create($data);
                logActivity('create', 'services', $id, 'Created service');
                setFlash('success', 'Service created.');
            } elseif ($action === 'edit' && isset($_POST['id'])) {
                $model->update((int) $_POST['id'], $data);
                logActivity('update', 'services', (int) $_POST['id'], 'Updated service');
                setFlash('success', 'Service updated.');
            }
            redirect(adminUrl('page=services'));
        }

        if ($action === 'create') {
            renderAdmin('services_form', ['pageHeading' => 'Add Service', 'service' => null]);
            return;
        }

        if ($action === 'edit' && isset($_GET['id'])) {
            $service = $model->findById((int) $_GET['id']);
            if (!$service) {
                redirect(adminUrl('page=services'));
            }
            renderAdmin('services_form', ['pageHeading' => 'Edit Service', 'service' => $service]);
            return;
        }

        renderAdmin('services', [
            'pageHeading' => 'Service Manager',
            'services' => $model->findAll('sort_order ASC'),
        ]);
    }

    private function serviceDataFromPost(): array
    {
        $approachLines = array_filter(array_map('trim', explode("\n", $_POST['approach_lines'] ?? '')));
        $approach = [];
        foreach ($approachLines as $i => $line) {
            $parts = explode('|', $line, 3);
            $approach[] = [
                'step' => $parts[0] ?? (string)($i + 1),
                'title' => $parts[1] ?? $line,
                'description' => $parts[2] ?? '',
            ];
        }

        $deliverables = array_values(array_filter(array_map('trim', explode("\n", $_POST['deliverables_lines'] ?? ''))));

        return [
            'slug' => slugify($_POST['slug'] ?? $_POST['title'] ?? ''),
            'title' => trim($_POST['title'] ?? ''),
            'icon' => trim($_POST['icon'] ?? 'fa-cog'),
            'short_description' => trim($_POST['short_description'] ?? ''),
            'intro' => $_POST['intro'] ?? '',
            'challenge' => $_POST['challenge'] ?? '',
            'approach' => json_encode($approach),
            'deliverables' => json_encode($deliverables),
            'benefits' => $_POST['benefits'] ?? '',
            'meta_title' => trim($_POST['meta_title'] ?? ''),
            'meta_description' => trim($_POST['meta_description'] ?? ''),
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            'is_published' => isset($_POST['is_published']) ? 1 : 0,
        ];
    }

    private function equipment(string $action): void
    {
        $model = new EquipmentModel();

        if ($action === 'delete' && isset($_GET['id'])) {
            $this->requireCsrfGet();
            $model->delete((int) $_GET['id']);
            setFlash('success', 'Equipment item deleted.');
            redirect(adminUrl('page=equipment'));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->requireCsrf();
            $data = [
                'category' => trim($_POST['category'] ?? ''),
                'name' => trim($_POST['name'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'icon' => trim($_POST['icon'] ?? 'fa-microscope'),
                'sort_order' => (int) ($_POST['sort_order'] ?? 0),
                'is_published' => isset($_POST['is_published']) ? 1 : 0,
            ];
            if ($action === 'create') {
                $model->create($data);
                setFlash('success', 'Equipment item created.');
            } elseif ($action === 'edit' && isset($_POST['id'])) {
                $model->update((int) $_POST['id'], $data);
                setFlash('success', 'Equipment item updated.');
            }
            redirect(adminUrl('page=equipment'));
        }

        if ($action === 'create') {
            renderAdmin('equipment_form', ['pageHeading' => 'Add Equipment', 'item' => null]);
            return;
        }

        if ($action === 'edit' && isset($_GET['id'])) {
            renderAdmin('equipment_form', ['pageHeading' => 'Edit Equipment', 'item' => $model->findById((int) $_GET['id'])]);
            return;
        }

        renderAdmin('equipment', [
            'pageHeading' => 'Equipment Manager',
            'items' => $model->findAll('category ASC, sort_order ASC'),
        ]);
    }

    private function blog(string $action): void
    {
        $model = new BlogModel();

        if ($action === 'delete' && isset($_GET['id'])) {
            $this->requireCsrfGet();
            $model->delete((int) $_GET['id']);
            setFlash('success', 'Blog post deleted.');
            redirect(adminUrl('page=blog'));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->requireCsrf();
            $data = [
                'category_id' => (int) ($_POST['category_id'] ?? 0) ?: null,
                'slug' => slugify($_POST['slug'] ?? $_POST['title'] ?? ''),
                'title' => trim($_POST['title'] ?? ''),
                'excerpt' => trim($_POST['excerpt'] ?? ''),
                'content' => $_POST['content'] ?? '',
                'meta_title' => trim($_POST['meta_title'] ?? ''),
                'meta_description' => trim($_POST['meta_description'] ?? ''),
                'is_published' => isset($_POST['is_published']) ? 1 : 0,
                'published_at' => $_POST['published_at'] ?? date('Y-m-d H:i:s'),
            ];
            if ($action === 'create') {
                $model->createPost($data);
                setFlash('success', 'Blog post created.');
            } elseif ($action === 'edit' && isset($_POST['id'])) {
                $model->updatePost((int) $_POST['id'], $data);
                setFlash('success', 'Blog post updated.');
            }
            redirect(adminUrl('page=blog'));
        }

        if ($action === 'create') {
            renderAdmin('blog_form', ['pageHeading' => 'Add Blog Post', 'post' => null, 'categories' => $model->getCategories()]);
            return;
        }

        if ($action === 'edit' && isset($_GET['id'])) {
            renderAdmin('blog_form', [
                'pageHeading' => 'Edit Blog Post',
                'post' => $model->findById((int) $_GET['id']),
                'categories' => $model->getCategories(),
            ]);
            return;
        }

        $db = Database::getInstance();
        $posts = $db->query(
            'SELECT p.*, c.name AS category_name FROM blog_posts p LEFT JOIN blog_categories c ON c.id = p.category_id ORDER BY p.created_at DESC'
        )->fetchAll();

        renderAdmin('blog', ['pageHeading' => 'Blog Manager', 'posts' => $posts]);
    }

    private function testimonials(string $action): void
    {
        $model = new TestimonialModel();

        if ($action === 'delete' && isset($_GET['id'])) {
            $this->requireCsrfGet();
            $model->delete((int) $_GET['id']);
            setFlash('success', 'Testimonial deleted.');
            redirect(adminUrl('page=testimonials'));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->requireCsrf();
            $data = [
                'client_name' => trim($_POST['client_name'] ?? ''),
                'organization' => trim($_POST['organization'] ?? ''),
                'role' => trim($_POST['role'] ?? ''),
                'content' => trim($_POST['content'] ?? ''),
                'outcome_metric' => trim($_POST['outcome_metric'] ?? ''),
                'rating' => (int) ($_POST['rating'] ?? 5),
                'is_published' => isset($_POST['is_published']) ? 1 : 0,
                'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            ];
            if ($action === 'create') {
                $model->create($data);
                setFlash('success', 'Testimonial created.');
            } elseif ($action === 'edit' && isset($_POST['id'])) {
                $model->update((int) $_POST['id'], $data);
                setFlash('success', 'Testimonial updated.');
            }
            redirect(adminUrl('page=testimonials'));
        }

        if ($action === 'create') {
            renderAdmin('testimonials_form', ['pageHeading' => 'Add Testimonial', 'item' => null]);
            return;
        }

        if ($action === 'edit' && isset($_GET['id'])) {
            renderAdmin('testimonials_form', ['pageHeading' => 'Edit Testimonial', 'item' => $model->findById((int) $_GET['id'])]);
            return;
        }

        renderAdmin('testimonials', [
            'pageHeading' => 'Testimonials Manager',
            'items' => $model->findAll('sort_order ASC'),
        ]);
    }

    private function faq(string $action): void
    {
        $model = new FaqModel();

        if ($action === 'delete' && isset($_GET['id'])) {
            $this->requireCsrfGet();
            $model->delete((int) $_GET['id']);
            setFlash('success', 'FAQ deleted.');
            redirect(adminUrl('page=faq'));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->requireCsrf();
            $data = [
                'question' => trim($_POST['question'] ?? ''),
                'answer' => trim($_POST['answer'] ?? ''),
                'sort_order' => (int) ($_POST['sort_order'] ?? 0),
                'is_published' => isset($_POST['is_published']) ? 1 : 0,
            ];
            if ($action === 'create') {
                $model->create($data);
                setFlash('success', 'FAQ created.');
            } elseif ($action === 'edit' && isset($_POST['id'])) {
                $model->update((int) $_POST['id'], $data);
                setFlash('success', 'FAQ updated.');
            }
            redirect(adminUrl('page=faq'));
        }

        if ($action === 'create') {
            renderAdmin('faq_form', ['pageHeading' => 'Add FAQ', 'item' => null]);
            return;
        }

        if ($action === 'edit' && isset($_GET['id'])) {
            renderAdmin('faq_form', [
                'pageHeading' => 'Edit FAQ',
                'item' => $model->findById((int) $_GET['id']),
            ]);
            return;
        }

        renderAdmin('faq', [
            'pageHeading' => 'FAQ Manager',
            'items' => $model->findAll('sort_order ASC, id ASC'),
        ]);
    }

    private function messages(string $action): void
    {
        $model = new MessageModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'reply') {
            $this->requireCsrf();
            $id = (int) ($_POST['message_id'] ?? 0);
            $original = $id ? $model->findById($id) : null;

            if (!$original) {
                setFlash('danger', 'Message not found.');
                redirect(adminUrl('page=messages'));
            }

            $subject = trim($_POST['subject'] ?? '');
            $body = trim($_POST['body'] ?? '');

            if ($subject === '' || $body === '') {
                setFlash('danger', 'Subject and reply message are required.');
                redirect(adminUrl('page=messages&view=' . $id));
            }

            $fullBody = $body . "\n\n---\nIn reply to your message on "
                . formatDate($original['created_at'], 'd M Y H:i') . ":\n" . $original['message'];

            $replyTo = getSetting('email', config('mail.admin_email'));
            $sent = sendMail($original['email'], $subject, $fullBody, $replyTo);

            $model->createReply($id, currentUserId(), $subject, $body, $sent);
            logActivity('reply', 'messages', $id, $sent ? 'Replied to contact message' : 'Reply saved but email failed');

            if ($sent) {
                setFlash('success', 'Reply sent to ' . $original['email'] . '.');
            } else {
                setFlash('danger', 'Reply saved to thread but email could not be sent. Verify Hostinger mail settings, or use Open in Email App.');
            }

            redirect(adminUrl('page=messages&view=' . $id));
        }

        if ($action === 'read' && isset($_GET['id'])) {
            $model->markRead((int) $_GET['id']);
            redirect(adminUrl('page=messages&view=' . (int) $_GET['id']));
        }

        $viewId = isset($_GET['view']) ? (int) $_GET['view'] : null;
        $viewMessage = $viewId ? $model->findById($viewId) : null;
        if ($viewMessage && !$viewMessage['is_read']) {
            $model->markRead($viewId);
        }

        renderAdmin('messages', [
            'pageHeading' => 'Contact Messages',
            'messages' => $model->getRecent(50),
            'viewMessage' => $viewMessage,
            'replies' => $viewId ? $model->getReplies($viewId) : [],
            'services' => (new ServiceModel())->getPublished(),
        ]);
    }

    private function seo(string $action): void
    {
        $model = new SeoModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'save') {
            $this->requireCsrf();
            $key = $_POST['page_key'] ?? '';
            $model->upsert($key, [
                'meta_title' => $_POST['meta_title'] ?? '',
                'meta_description' => $_POST['meta_description'] ?? '',
                'meta_keywords' => $_POST['meta_keywords'] ?? '',
            ]);
            setFlash('success', 'SEO settings saved.');
            redirect(adminUrl('page=seo&edit=' . urlencode($key)));
        }

        $pages = $model->getAll();
        $editKey = $_GET['edit'] ?? ($pages[0]['page_key'] ?? 'home');
        $editPage = null;
        foreach ($pages as $p) {
            if ($p['page_key'] === $editKey) {
                $editPage = $p;
                break;
            }
        }

        renderAdmin('seo', [
            'pageHeading' => 'SEO Settings',
            'pages' => $pages,
            'editPage' => $editPage,
            'editKey' => $editKey,
        ]);
    }

    private function settings(string $action): void
    {
        $model = new SettingsModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->requireCsrf();
            $keys = ['site_name', 'tagline', 'phone', 'email', 'address', 'linkedin', 'response_time', 'footer_text', 'contact_intro', 'privacy_content', 'terms_content'];
            foreach ($keys as $key) {
                if (isset($_POST[$key])) {
                    $model->set($key, $_POST[$key]);
                }
            }
            logActivity('update', 'website_settings', null, 'Updated website settings');
            setFlash('success', 'Website settings saved.');
            redirect(adminUrl('page=settings'));
        }

        renderAdmin('settings', [
            'pageHeading' => 'Website Settings',
            'settings' => $model->getAll(),
        ]);
    }

    private function media(string $action): void
    {
        $model = new MediaModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'upload') {
            $this->requireCsrf();
            if (!empty($_FILES['file'])) {
                $result = $model->handleUpload($_FILES['file']);
                if ($result) {
                    setFlash('success', 'File uploaded successfully.');
                } else {
                    setFlash('danger', 'Upload failed. Check file type (jpg, png, webp) and size (max 5MB).');
                }
            }
            redirect(adminUrl('page=media'));
        }

        if ($action === 'delete' && isset($_GET['id'])) {
            $this->requireCsrfGet();
            $item = $model->findById((int) $_GET['id']);
            if ($item) {
                $path = rtrim(config('upload.path'), '/\\') . DIRECTORY_SEPARATOR . $item['filename'];
                if (file_exists($path)) {
                    unlink($path);
                }
                $model->delete((int) $_GET['id']);
            }
            setFlash('success', 'Media deleted.');
            redirect(adminUrl('page=media'));
        }

        renderAdmin('media', [
            'pageHeading' => 'Media Library',
            'items' => $model->findAll('uploaded_at DESC'),
        ]);
    }

    private function profile(string $action): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'password') {
            $this->requireCsrf();
            $ok = changePassword(
                currentUserId(),
                $_POST['current_password'] ?? '',
                $_POST['new_password'] ?? ''
            );
            setFlash($ok ? 'success' : 'danger', $ok ? 'Password updated.' : 'Current password is incorrect.');
            redirect(adminUrl('page=profile'));
        }

        renderAdmin('profile', ['pageHeading' => 'Admin Profile', 'user' => currentUser()]);
    }

    private function requireCsrf(): void
    {
        if (!verifyCsrf($_POST['csrf_token'] ?? '')) {
            setFlash('danger', 'Invalid security token.');
            redirect(adminUrl());
        }
    }

    private function requireCsrfGet(): void
    {
        if (!verifyCsrf($_GET['csrf_token'] ?? '')) {
            setFlash('danger', 'Invalid security token.');
            redirect(adminUrl());
        }
    }
}
