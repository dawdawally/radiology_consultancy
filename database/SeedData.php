<?php

declare(strict_types=1);

/**
 * Radiation Equipment Consultancy — database seed data.
 * Run via install.php or: SeedData::run($pdo);
 */
class SeedData
{
    public static function run(PDO $pdo): void
    {
        if (!self::tableExists($pdo, 'admin_users')) {
            throw new RuntimeException('Required database tables are missing. Run schema.sql first.');
        }

        $pdo->beginTransaction();

        try {
            self::seedAdminUsers($pdo);
            self::seedWebsiteSettings($pdo);
            self::seedHomepage($pdo);
            self::seedAbout($pdo);
            self::seedServices($pdo);
            self::seedEquipment($pdo);
            self::seedBlogCategories($pdo);
            self::seedBlogPosts($pdo);
            self::seedTestimonials($pdo);
            self::seedSeo($pdo);

            $pdo->commit();
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }

    private static function tableExists(PDO $pdo, string $table): bool
    {
        $stmt = $pdo->prepare(
            'SELECT COUNT(*) FROM information_schema.tables
             WHERE table_schema = DATABASE() AND table_name = ?'
        );
        $stmt->execute([$table]);

        return (int) $stmt->fetchColumn() > 0;
    }

    private static function seedAdminUsers(PDO $pdo): void
    {
        $stmt = $pdo->prepare(
            'INSERT INTO admin_users (username, email, full_name, password_hash)
             VALUES (?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE
                email = VALUES(email),
                full_name = VALUES(full_name)'
        );
        $stmt->execute(['admin', 'admin@radiationequipmentconsultancy.com', 'Site Administrator', 'TEMP']);
    }

    private static function seedWebsiteSettings(PDO $pdo): void
    {
        $settings = [
            'site_name' => 'Radiation Equipment Consultancy',
            'tagline' => 'Independent radiation equipment expertise for hospitals and cancer centres worldwide',
            'phone' => '+44 (0)20 7946 0958',
            'email' => 'info@radiationequipmentconsultancy.com',
            'address' => 'Radiation Equipment Consultancy, 14 Harley Street, London W1G 9PQ, United Kingdom',
            'linkedin' => 'https://www.linkedin.com/company/radiation-equipment-consultancy',
            'response_time' => 'We respond to all enquiries within 24 hours on business days.',
            'footer_text' => 'Radiation Equipment Consultancy provides independent technical advisory services for radiation equipment across radiotherapy, diagnostic radiology, and nuclear medicine. We do not sell equipment and have no manufacturer affiliations.',
            'contact_intro' => '<p>Whether you are planning a new installation, commissioning a linac, or navigating regulatory compliance, we are here to help. Tell us about your project and we will respond within one business day with practical next steps.</p>',
            'privacy_content' => self::privacyContent(),
            'terms_content' => self::termsContent(),
        ];

        $stmt = $pdo->prepare(
            'INSERT INTO website_settings (setting_key, setting_value)
             VALUES (?, ?)
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)'
        );

        foreach ($settings as $key => $value) {
            $stmt->execute([$key, $value]);
        }
    }

    private static function privacyContent(): string
    {
        return <<<'HTML'
<p>Radiation Equipment Consultancy ("we", "us", or "our") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, store, and safeguard personal information when you visit our website or contact us for consultancy services.</p>
<p><strong>Information We Collect</strong></p>
<p>We may collect personal information that you voluntarily provide through our contact form, email correspondence, or telephone enquiries. This may include your name, job title, organisation, email address, telephone number, and details about your radiation equipment project or enquiry. We also collect limited technical data automatically when you browse our website, such as IP address, browser type, pages visited, and referral source, through standard server logs and analytics tools.</p>
<p><strong>How We Use Your Information</strong></p>
<p>We use your information to respond to enquiries, provide consultancy services, prepare proposals, communicate about projects, improve our website, and comply with legal obligations. We do not sell, rent, or trade your personal data to third parties. We may share information with trusted service providers who assist us in operating our website or delivering services, provided they agree to keep your information confidential and process it only on our instructions.</p>
<p><strong>Data Retention and Security</strong></p>
<p>We retain contact form submissions and project correspondence only for as long as necessary to fulfil the purpose for which it was collected, or as required by applicable law and professional record-keeping obligations. We implement appropriate technical and organisational measures to protect personal data against unauthorised access, alteration, disclosure, or destruction.</p>
<p><strong>Your Rights</strong></p>
<p>Depending on your location, you may have rights to access, correct, delete, or restrict processing of your personal data, and to object to certain processing activities. To exercise these rights, please contact us at info@radiationequipmentconsultancy.com. We will respond within a reasonable timeframe.</p>
<p><strong>Cookies and Analytics</strong></p>
<p>Our website may use cookies and similar technologies to improve user experience and analyse traffic patterns. You can control cookie preferences through your browser settings. Where we use analytics services such as Google Analytics, data is processed in accordance with the provider's terms and applicable privacy regulations.</p>
<p><strong>International Transfers</strong></p>
<p>As we support clients globally, your information may be processed in countries outside your own. Where this occurs, we ensure appropriate safeguards are in place consistent with applicable data protection legislation.</p>
<p><strong>Changes to This Policy</strong></p>
<p>We may update this Privacy Policy from time to time. The revised version will be posted on this page with an updated effective date. We encourage you to review this policy periodically.</p>
<p><strong>Contact Us</strong></p>
<p>If you have questions about this Privacy Policy or how we handle your personal data, please contact us at info@radiationequipmentconsultancy.com or write to Radiation Equipment Consultancy, 14 Harley Street, London W1G 9PQ, United Kingdom.</p>
HTML;
    }

    private static function termsContent(): string
    {
        return <<<'HTML'
<p>These Terms of Use govern your access to and use of the Radiation Equipment Consultancy website. By using this website, you agree to these terms. If you do not agree, please do not use our site.</p>
<p><strong>Website Content</strong></p>
<p>The information on this website is provided for general informational purposes about our radiation equipment consultancy services. While we strive to keep content accurate and up to date, we make no warranties, express or implied, regarding completeness, reliability, or suitability for any particular purpose. Technical and regulatory requirements vary by jurisdiction and facility type; specific advice should always be obtained through a formal consultancy engagement.</p>
<p><strong>No Professional Relationship</strong></p>
<p>Submitting a contact form or browsing our website does not create a client-consultant relationship. A professional engagement is established only when we have agreed scope, fees, and terms in a written proposal or contract. Nothing on this website constitutes medical, legal, or regulatory advice for your specific circumstances.</p>
<p><strong>Intellectual Property</strong></p>
<p>All content on this website — including text, graphics, logos, images, and layout — is the property of Radiation Equipment Consultancy or our licensors and is protected by copyright and intellectual property laws. You may not reproduce, distribute, modify, or create derivative works without our prior written consent, except for personal, non-commercial viewing or printing of pages for reference.</p>
<p><strong>Limitation of Liability</strong></p>
<p>To the fullest extent permitted by law, Radiation Equipment Consultancy shall not be liable for any direct, indirect, incidental, consequential, or special damages arising from your use of this website or reliance on its content. This includes loss of data, business interruption, or equipment downtime, even if we have been advised of the possibility of such damages.</p>
<p><strong>Third-Party Links</strong></p>
<p>Our website may contain links to third-party websites for your convenience. We do not endorse and are not responsible for the content, privacy practices, or availability of external sites. Accessing linked sites is at your own risk.</p>
<p><strong>Acceptable Use</strong></p>
<p>You agree not to use this website for any unlawful purpose, to transmit harmful code, to attempt unauthorised access to our systems, or to interfere with the proper functioning of the site. We reserve the right to restrict access to users who violate these terms.</p>
<p><strong>Governing Law</strong></p>
<p>These Terms of Use are governed by the laws of England and Wales. Any disputes arising from use of this website shall be subject to the exclusive jurisdiction of the courts of England and Wales, unless otherwise agreed in a separate consultancy contract.</p>
<p><strong>Changes to These Terms</strong></p>
<p>We may revise these Terms of Use at any time by updating this page. Continued use of the website after changes are posted constitutes acceptance of the revised terms.</p>
<p><strong>Contact</strong></p>
<p>For questions about these Terms of Use, please contact us at info@radiationequipmentconsultancy.com.</p>
HTML;
    }

    private static function seedHomepage(PDO $pdo): void
    {
        $sections = [
            [
                'section_key' => 'hero',
                'title' => 'Expert Radiation Equipment Consultancy',
                'subtitle' => 'From installation and commissioning to regulatory compliance — we partner with hospitals, cancer centres, and imaging facilities worldwide.',
                'content' => '<p>We bring decades of hands-on experience across radiotherapy, diagnostic radiology, and nuclear medicine. Our independent consultancy helps you deliver safe, compliant, and clinically effective radiation programmes without manufacturer bias.</p>',
                'button_text' => 'Request a Consultation',
                'button_url' => '/contact',
                'extra_data' => null,
                'sort_order' => 1,
            ],
            [
                'section_key' => 'about_preview',
                'title' => 'Trusted Technical Partners',
                'subtitle' => 'Independent expertise you can rely on at every stage of your equipment lifecycle.',
                'content' => '<p>Radiation Equipment Consultancy is a specialist team of medical physicists, biomedical engineers, and radiation safety professionals. We support facilities from pre-purchase planning through installation, commissioning, staff training, and ongoing quality assurance — always putting patient safety and regulatory compliance first.</p>',
                'button_text' => 'Learn About Us',
                'button_url' => '/about',
                'extra_data' => null,
                'sort_order' => 2,
            ],
            [
                'section_key' => 'services_intro',
                'title' => 'Comprehensive Consultancy Services',
                'subtitle' => 'End-to-end support for radiation equipment projects of every scale.',
                'content' => '<p>Whether you are installing a new linac, commissioning a CT scanner, or decommissioning legacy equipment, we provide structured, evidence-based consultancy aligned with international standards and local regulatory requirements.</p>',
                'button_text' => 'View All Services',
                'button_url' => '/services',
                'extra_data' => null,
                'sort_order' => 3,
            ],
            [
                'section_key' => 'equipment_intro',
                'title' => 'Equipment Expertise Across Modalities',
                'subtitle' => 'Deep technical knowledge spanning radiotherapy, diagnostic radiology, and nuclear medicine.',
                'content' => '<p>We work with the full spectrum of radiation-producing equipment — from linear accelerators and Gamma Knife systems to PET-CT scanners and gamma cameras. Our team understands manufacturer specifications, clinical workflows, and the practical realities of hospital implementation.</p>',
                'button_text' => 'Explore Equipment',
                'button_url' => '/equipment',
                'extra_data' => null,
                'sort_order' => 4,
            ],
            [
                'section_key' => 'why_choose_us',
                'title' => 'Why Facilities Choose Us',
                'subtitle' => 'We combine technical authority with a collaborative, safety-first approach.',
                'content' => null,
                'button_text' => null,
                'button_url' => null,
                'extra_data' => json_encode([
                    'items' => [
                        [
                            'icon' => 'fa-shield-halved',
                            'title' => 'Safety First',
                            'description' => 'We embed radiation protection and risk management into every project phase, ensuring staff and patient safety remain the top priority.',
                        ],
                        [
                            'icon' => 'fa-scale-balanced',
                            'title' => 'Regulatory Expertise',
                            'description' => 'We navigate complex licensing, notification, and inspection requirements across multiple jurisdictions so your facility stays compliant.',
                        ],
                        [
                            'icon' => 'fa-microscope',
                            'title' => 'Technical Authority',
                            'description' => 'Our consultants bring certified qualifications and direct field experience with major equipment platforms and QA protocols.',
                        ],
                        [
                            'icon' => 'fa-handshake',
                            'title' => 'Client Partnership',
                            'description' => 'We work alongside your clinical, engineering, and management teams — not as outsiders — to achieve shared project goals.',
                        ],
                        [
                            'icon' => 'fa-globe',
                            'title' => 'Global Reach',
                            'description' => 'We support projects internationally, adapting our methodology to local standards while maintaining consistent quality.',
                        ],
                    ],
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'sort_order' => 5,
            ],
            [
                'section_key' => 'process',
                'title' => 'How We Work With You',
                'subtitle' => 'A clear, structured process from initial enquiry to project completion.',
                'content' => null,
                'button_text' => null,
                'button_url' => null,
                'extra_data' => json_encode([
                    'items' => [
                        [
                            'icon' => 'fa-comments',
                            'title' => 'Initial Consultation',
                            'description' => 'We discuss your objectives, timeline, equipment, and regulatory context to understand the full scope of your needs.',
                        ],
                        [
                            'icon' => 'fa-file-lines',
                            'title' => 'Proposal & Planning',
                            'description' => 'We deliver a detailed proposal with deliverables, milestones, and resource requirements tailored to your facility.',
                        ],
                        [
                            'icon' => 'fa-screwdriver-wrench',
                            'title' => 'On-Site Execution',
                            'description' => 'Our team provides hands-on technical support during installation, commissioning, testing, training, or relocation activities.',
                        ],
                        [
                            'icon' => 'fa-clipboard-check',
                            'title' => 'Documentation & Handover',
                            'description' => 'We produce comprehensive reports, test records, and compliance documentation for your records and regulators.',
                        ],
                        [
                            'icon' => 'fa-arrows-rotate',
                            'title' => 'Ongoing Support',
                            'description' => 'We remain available for QA reviews, regulatory updates, and technical advisory as your programme evolves.',
                        ],
                    ],
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'sort_order' => 6,
            ],
            [
                'section_key' => 'cta',
                'title' => 'Ready to Discuss Your Project?',
                'subtitle' => 'We respond to all enquiries within 24 hours on business days.',
                'content' => '<p>Whether you need a single commissioning visit or full project management for a multi-modality installation, we are ready to help. Contact us today for an independent, no-obligation consultation.</p>',
                'button_text' => 'Get in Touch',
                'button_url' => '/contact',
                'extra_data' => null,
                'sort_order' => 7,
            ],
        ];

        $stmt = $pdo->prepare(
            'INSERT INTO homepage (section_key, title, subtitle, content, button_text, button_url, extra_data, sort_order, is_active)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)
             ON DUPLICATE KEY UPDATE
                title = VALUES(title),
                subtitle = VALUES(subtitle),
                content = VALUES(content),
                button_text = VALUES(button_text),
                button_url = VALUES(button_url),
                extra_data = VALUES(extra_data),
                sort_order = VALUES(sort_order),
                is_active = VALUES(is_active)'
        );

        foreach ($sections as $section) {
            $stmt->execute([
                $section['section_key'],
                $section['title'],
                $section['subtitle'],
                $section['content'],
                $section['button_text'],
                $section['button_url'],
                $section['extra_data'],
                $section['sort_order'],
            ]);
        }
    }

    private static function seedAbout(PDO $pdo): void
    {
        $sections = [
            [
                'section_key' => 'intro',
                'title' => 'About Radiation Equipment Consultancy',
                'content' => '<p>Radiation Equipment Consultancy is an independent advisory practice specialising in radiation-producing medical equipment. We support hospitals, cancer centres, diagnostic imaging departments, and nuclear medicine facilities at every stage of the equipment lifecycle — from strategic planning and vendor selection through installation, commissioning, staff training, and long-term quality assurance.</p><p>Founded by experienced medical physicists and biomedical engineers, we formed our practice to fill a gap we saw repeatedly in the field: facilities needed impartial, deeply technical guidance that was not tied to any equipment manufacturer or reseller. Today we work with clients across Europe, the Middle East, Africa, and Asia-Pacific, bringing the same rigorous standards and collaborative approach to every engagement.</p><p>Our mission is straightforward — we help healthcare organisations deploy and maintain radiation equipment safely, compliantly, and clinically effectively, so clinical teams can focus on what matters most: patient care.</p>',
                'extra_data' => null,
                'sort_order' => 1,
            ],
            [
                'section_key' => 'qualifications',
                'title' => 'Our Qualifications',
                'content' => '<p>Our consultancy team holds advanced qualifications in medical physics, biomedical engineering, and radiation protection. Senior consultants are registered with recognised professional bodies and maintain active continuing professional development in line with evolving standards.</p><p>Collectively, we bring experience spanning:</p><ul><li>External beam radiotherapy — photon and electron linacs, stereotactic systems, and proton therapy</li><li>Diagnostic imaging — CT, digital radiography, mammography, and fluoroscopy</li><li>Nuclear medicine — gamma cameras, SPECT, and PET-CT systems</li><li>Radiation safety programme design and regulatory liaison</li><li>Clinical dosimetry, QA protocol development, and acceptance testing</li></ul><p>We have led commissioning programmes for greenfield cancer centres, supported major hospital refurbishments, and advised on equipment selection for facilities investing in their first radiation therapy or molecular imaging capabilities.</p>',
                'extra_data' => null,
                'sort_order' => 2,
            ],
            [
                'section_key' => 'certifications',
                'title' => 'Certifications & Professional Standards',
                'content' => '<p>We align our work with internationally recognised standards and guidelines, including IAEA safety standards, AAPM Task Group reports, IEC equipment standards, and manufacturer-specific acceptance protocols. Our consultants hold or have held certifications relevant to their areas of practice.</p><ul><li>Registration with national medical physics and engineering professional bodies</li><li>Radiation protection supervisor and RPA-equivalent qualifications</li><li>Manufacturer-authorised training on major linac, CT, and nuclear medicine platforms</li><li>ISO 9001-aligned quality management practices for documentation and traceability</li><li>Regular participation in professional conferences and standards committee review</li></ul><p>We maintain comprehensive professional indemnity insurance and operate under clear conflict-of-interest policies. We do not accept commissions from equipment vendors, ensuring our recommendations remain fully independent.</p>',
                'extra_data' => null,
                'sort_order' => 3,
            ],
            [
                'section_key' => 'safety_philosophy',
                'title' => 'Our Safety Philosophy',
                'content' => '<p>At Radiation Equipment Consultancy, safety is not a checkbox at the end of a project — it is the foundation of everything we do. Radiation equipment has the potential to deliver life-saving treatment and diagnosis, but only when installed, commissioned, and operated within strict safety and quality parameters.</p><p>Our safety philosophy rests on three principles:</p><p><strong>Prevention through design.</strong> We review shielding calculations, room layouts, interlocks, and workflow design early in every project so that safety is engineered in, not patched on later.</p><p><strong>Evidence-based verification.</strong> We apply rigorous acceptance testing, dosimetry checks, and documentation at commissioning to confirm equipment performs as specified before clinical use begins.</p><p><strong>Culture of continuous improvement.</strong> We train staff not just to operate equipment, but to understand the safety rationale behind procedures, empowering teams to identify and escalate concerns proactively.</p><p>We believe that regulatory compliance and clinical excellence are two sides of the same coin. When safety is done right, facilities pass inspections naturally and clinicians gain confidence in their technology.</p>',
                'extra_data' => null,
                'sort_order' => 4,
            ],
            [
                'section_key' => 'team',
                'title' => 'Our Team',
                'content' => '<p>We are built around a core team of senior consultants, each bringing 15–25 years of field experience across multiple equipment platforms and healthcare settings. We supplement our permanent team with specialist associates for large-scale or multi-site projects, ensuring the right expertise is always on site.</p><p>Our team structure includes:</p><ul><li><strong>Senior Medical Physicists</strong> — leading radiotherapy commissioning, dosimetry, and QA programme design</li><li><strong>Biomedical Engineers</strong> — overseeing installation coordination, acceptance testing, and preventive maintenance planning</li><li><strong>Radiation Safety Specialists</strong> — managing regulatory documentation, shielding review, and compliance audits</li><li><strong>Clinical Training Coordinators</strong> — developing and delivering tailored staff training programmes</li><li><strong>Project Managers</strong> — coordinating multi-disciplinary equipment projects from planning through handover</li></ul><p>We pride ourselves on being approachable, responsive, and genuinely invested in our clients\' success. When you work with MedRad, you get direct access to senior consultants — not junior staff learning on your project.</p>',
                'extra_data' => null,
                'sort_order' => 5,
            ],
        ];

        $stmt = $pdo->prepare(
            'INSERT INTO about (section_key, title, content, extra_data, sort_order)
             VALUES (?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE
                title = VALUES(title),
                content = VALUES(content),
                extra_data = VALUES(extra_data),
                sort_order = VALUES(sort_order)'
        );

        foreach ($sections as $section) {
            $stmt->execute([
                $section['section_key'],
                $section['title'],
                $section['content'],
                $section['extra_data'],
                $section['sort_order'],
            ]);
        }
    }

    private static function seedServices(PDO $pdo): void
    {
        $services = self::getServicesData();

        $stmt = $pdo->prepare(
            'INSERT INTO services (slug, title, icon, short_description, intro, challenge, approach, deliverables, benefits, meta_title, meta_description, sort_order, is_published)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)
             ON DUPLICATE KEY UPDATE
                title = VALUES(title),
                icon = VALUES(icon),
                short_description = VALUES(short_description),
                intro = VALUES(intro),
                challenge = VALUES(challenge),
                approach = VALUES(approach),
                deliverables = VALUES(deliverables),
                benefits = VALUES(benefits),
                meta_title = VALUES(meta_title),
                meta_description = VALUES(meta_description),
                sort_order = VALUES(sort_order),
                is_published = VALUES(is_published)'
        );

        foreach ($services as $service) {
            $stmt->execute([
                $service['slug'],
                $service['title'],
                $service['icon'],
                $service['short_description'],
                $service['intro'],
                $service['challenge'],
                $service['approach'],
                $service['deliverables'],
                $service['benefits'],
                $service['meta_title'],
                $service['meta_description'],
                $service['sort_order'],
            ]);
        }
    }

    private static function getServicesData(): array
    {
        return [
            [
                'slug' => 'installation-services',
                'title' => 'Installation Services',
                'icon' => 'fa-truck-ramp-box',
                'short_description' => 'End-to-end coordination of radiation equipment installation, from site readiness through vendor handover.',
                'intro' => '<p>Successful equipment installation requires far more than unloading crates and connecting power. We provide comprehensive installation oversight for radiotherapy linacs, diagnostic imaging systems, and nuclear medicine equipment — ensuring your facility is genuinely ready before the vendor arrives on site.</p>',
                'challenge' => '<p>Hospitals frequently underestimate the complexity of radiation equipment installation. Inadequate shielding, incorrect room dimensions, missing utilities, or poor coordination between contractors and vendors can delay projects by weeks or months and introduce safety risks that are expensive to correct later.</p>',
                'approach' => json_encode([
                    ['step' => 1, 'title' => 'Site Readiness Assessment', 'description' => 'We review architectural drawings, shielding reports, electrical and HVAC specifications, and floor load requirements against manufacturer installation manuals.'],
                    ['step' => 2, 'title' => 'Pre-Installation Coordination', 'description' => 'We liaise with vendors, contractors, and hospital engineering teams to establish timelines, access routes, and responsibility matrices.'],
                    ['step' => 3, 'title' => 'On-Site Installation Oversight', 'description' => 'We attend key installation milestones, verify component integrity, and document any deviations from specification.'],
                    ['step' => 4, 'title' => 'Post-Installation Verification', 'description' => 'We confirm mechanical installation completeness and readiness for commissioning, producing a structured handover report.'],
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'deliverables' => json_encode([
                    'Site readiness checklist and gap analysis report',
                    'Installation oversight log with photographic documentation',
                    'Deviation and non-conformance register',
                    'Pre-commissioning readiness certificate',
                    'Stakeholder communication plan and meeting minutes',
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'benefits' => '<p>Facilities that engage us for installation oversight typically avoid costly rework, reduce vendor standby charges, and achieve faster transitions to commissioning. We protect your capital investment by ensuring the foundation is right before clinical testing begins.</p>',
                'meta_title' => 'Radiation Equipment Installation Services | Radiation Equipment Consultancy',
                'meta_description' => 'Independent installation oversight for linacs, CT scanners, and nuclear medicine equipment. We ensure site readiness and coordinate vendors for on-time, safe deployments.',
                'sort_order' => 1,
            ],
            [
                'slug' => 'commissioning-acceptance-testing',
                'title' => 'Commissioning & Acceptance Testing',
                'icon' => 'fa-clipboard-check',
                'short_description' => 'Rigorous commissioning and acceptance testing to verify equipment safety, performance, and regulatory compliance.',
                'intro' => '<p>Commissioning is the critical bridge between installation and clinical operation. We perform comprehensive acceptance testing for radiation equipment, validating that every system meets manufacturer specifications, international standards, and your local regulatory requirements before patients are treated or imaged.</p>',
                'challenge' => '<p>Vendor commissioning packages vary in scope and depth. Facilities may lack the in-house physics or engineering capacity to verify results independently, creating reliance on manufacturer assurances alone. Incomplete commissioning is a leading cause of clinical incidents and failed regulatory inspections.</p>',
                'approach' => json_encode([
                    ['step' => 1, 'title' => 'Commissioning Protocol Development', 'description' => 'We define test protocols aligned with IAEA, AAPM, IEC, and manufacturer requirements specific to your equipment model.'],
                    ['step' => 2, 'title' => 'Baseline Measurements', 'description' => 'We perform or witness dosimetry, image quality, mechanical, and safety interlock testing with calibrated instruments.'],
                    ['step' => 3, 'title' => 'Independent Verification', 'description' => 'We cross-check vendor results, identify discrepancies, and require corrective action before sign-off.'],
                    ['step' => 4, 'title' => 'Clinical Release Documentation', 'description' => 'We compile a complete commissioning dossier suitable for regulatory submission and clinical governance review.'],
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'deliverables' => json_encode([
                    'Commissioning and acceptance test protocols',
                    'Measurement results with traceable calibration records',
                    'Independent verification report',
                    'Beam data or image quality baseline datasets',
                    'Regulatory-ready commissioning summary',
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'benefits' => '<p>Independent commissioning gives your clinical team confidence that equipment is safe and accurate from day one. We reduce regulatory risk, accelerate inspection readiness, and establish QA baselines that support long-term programme integrity.</p>',
                'meta_title' => 'Medical Equipment Commissioning & Acceptance Testing | Radiation Equipment Consultancy',
                'meta_description' => 'Expert linac commissioning, CT acceptance testing, and nuclear medicine verification. Independent QA protocols aligned with IAEA and AAPM standards.',
                'sort_order' => 2,
            ],
            [
                'slug' => 'staff-training',
                'title' => 'Staff Training',
                'icon' => 'fa-chalkboard-user',
                'short_description' => 'Tailored training programmes for clinical, technical, and radiation safety staff on new and existing equipment.',
                'intro' => '<p>Even the best equipment underperforms without properly trained staff. We design and deliver training programmes that bridge the gap between vendor basic training and the operational competence your facility needs for safe, efficient clinical use.</p>',
                'challenge' => '<p>Manufacturer training is often generic, time-limited, and focused on operation rather than safety culture. Staff turnover, multi-modality expansion, and evolving techniques mean training gaps persist long after equipment goes live, increasing error rates and compliance exposure.</p>',
                'approach' => json_encode([
                    ['step' => 1, 'title' => 'Training Needs Analysis', 'description' => 'We assess current competency levels, clinical workflows, and regulatory training requirements across affected staff groups.'],
                    ['step' => 2, 'title' => 'Curriculum Design', 'description' => 'We develop role-specific modules covering operation, QA, emergency procedures, and radiation protection principles.'],
                    ['step' => 3, 'title' => 'Delivery & Assessment', 'description' => 'We deliver classroom and hands-on sessions with competency assessments and practical evaluations.'],
                    ['step' => 4, 'title' => 'Documentation & Refresher Planning', 'description' => 'We provide training records, reference materials, and a recommended refresher schedule.'],
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'deliverables' => json_encode([
                    'Training needs analysis report',
                    'Customised training curriculum and slide packs',
                    'Competency assessment forms and results',
                    'Attendance records and certificates of completion',
                    'Quick-reference guides and standard operating procedure templates',
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'benefits' => '<p>Well-trained staff operate equipment more safely, reduce unplanned downtime, and adapt faster to new clinical techniques. We help you build a sustainable training culture that satisfies regulators and empowers your team.</p>',
                'meta_title' => 'Radiation Equipment Staff Training | Radiation Equipment Consultancy',
                'meta_description' => 'Custom staff training for radiotherapy, diagnostic imaging, and nuclear medicine teams. Competency-based programmes with documented assessment.',
                'sort_order' => 3,
            ],
            [
                'slug' => 'pre-purchase-consultation',
                'title' => 'Pre-Purchase Consultation & Equipment Selection',
                'icon' => 'fa-magnifying-glass-chart',
                'short_description' => 'Independent, vendor-neutral advice to help you select the right radiation equipment for your clinical and budgetary needs.',
                'intro' => '<p>Equipment selection is one of the most consequential decisions a healthcare facility makes. We provide impartial pre-purchase consultancy to help you evaluate options, understand total cost of ownership, and align technology choices with your clinical strategy and infrastructure constraints.</p>',
                'challenge' => '<p>Vendor demonstrations showcase equipment under ideal conditions. Without independent technical evaluation, facilities risk purchasing systems that do not fit their room, workflow, staffing model, or maintenance capacity — leading to costly retrofitting or underutilised capital investment.</p>',
                'approach' => json_encode([
                    ['step' => 1, 'title' => 'Clinical & Operational Requirements', 'description' => 'We facilitate stakeholder workshops to define clinical indications, patient volumes, and integration requirements.'],
                    ['step' => 2, 'title' => 'Technical Evaluation Matrix', 'description' => 'We score candidate systems against objective criteria including specifications, service support, upgrade path, and regulatory status.'],
                    ['step' => 3, 'title' => 'Infrastructure Compatibility Review', 'description' => 'We assess room suitability, shielding needs, utilities, IT integration, and civil works implications for each option.'],
                    ['step' => 4, 'title' => 'Recommendation Report', 'description' => 'We deliver a clear, evidence-based recommendation with rationale, risk assessment, and implementation considerations.'],
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'deliverables' => json_encode([
                    'Requirements specification document',
                    'Vendor evaluation scorecard',
                    'Infrastructure compatibility assessment',
                    'Total cost of ownership analysis',
                    'Final recommendation report with executive summary',
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'benefits' => '<p>Independent pre-purchase advice protects your investment and accelerates procurement decisions. We help you avoid expensive mistakes and select equipment that genuinely serves your patients and operational model.</p>',
                'meta_title' => 'Pre-Purchase Equipment Consultation | Radiation Equipment Consultancy',
                'meta_description' => 'Vendor-neutral radiation equipment selection advice for hospitals and cancer centres. We evaluate linacs, CT, PET-CT, and more against your clinical needs.',
                'sort_order' => 4,
            ],
            [
                'slug' => 'project-management',
                'title' => 'Project Management for Equipment Projects',
                'icon' => 'fa-diagram-project',
                'short_description' => 'Dedicated project management for complex radiation equipment installations and department upgrades.',
                'intro' => '<p>Radiation equipment projects involve multiple stakeholders, tight timelines, and significant regulatory obligations. We provide experienced project management to keep your installation, refurbishment, or technology upgrade on schedule, on budget, and fully documented.</p>',
                'challenge' => '<p>Hospital project teams are often stretched across competing priorities. Without dedicated radiation equipment project management, communication breakdowns between architects, contractors, vendors, and clinical staff cause delays, cost overruns, and safety-critical oversights.</p>',
                'approach' => json_encode([
                    ['step' => 1, 'title' => 'Project Charter & Governance', 'description' => 'We establish scope, milestones, RACI matrices, and escalation pathways with clear decision-making authority.'],
                    ['step' => 2, 'title' => 'Integrated Planning', 'description' => 'We develop master schedules linking civil works, utilities, vendor deliveries, commissioning, and clinical go-live dates.'],
                    ['step' => 3, 'title' => 'Stakeholder Coordination', 'description' => 'We chair regular progress meetings, track action items, and maintain transparent reporting to hospital leadership.'],
                    ['step' => 4, 'title' => 'Risk & Change Management', 'description' => 'We proactively identify risks, manage scope changes, and ensure documentation keeps pace with project evolution.'],
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'deliverables' => json_encode([
                    'Project management plan and master schedule',
                    'Weekly progress reports and dashboard metrics',
                    'Risk register and mitigation action log',
                    'Meeting minutes and decision records',
                    'Project close-out report with lessons learned',
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'benefits' => '<p>Structured project management reduces delays, controls costs, and ensures nothing falls through the cracks. We give hospital leadership visibility and confidence throughout the project lifecycle.</p>',
                'meta_title' => 'Radiation Equipment Project Management | Radiation Equipment Consultancy',
                'meta_description' => 'Expert project management for linac installations, imaging suite upgrades, and nuclear medicine deployments. On-time delivery with full documentation.',
                'sort_order' => 5,
            ],
            [
                'slug' => 'radiation-safety-compliance',
                'title' => 'Radiation Safety & Regulatory Compliance',
                'icon' => 'fa-shield-halved',
                'short_description' => 'Comprehensive radiation safety advisory and regulatory compliance support for licensed facilities.',
                'intro' => '<p>Operating radiation equipment carries significant legal and ethical responsibilities. We help facilities design, implement, and maintain radiation safety programmes that meet regulatory requirements and protect staff, patients, and the public.</p>',
                'challenge' => '<p>Regulatory frameworks for radiation use are complex and frequently updated. Facilities struggle to keep policies current, maintain adequate shielding documentation, and prepare for inspections — especially when expanding services or adopting new technologies.</p>',
                'approach' => json_encode([
                    ['step' => 1, 'title' => 'Compliance Gap Analysis', 'description' => 'We review existing licences, local rules, risk assessments, and shielding documentation against current regulatory requirements.'],
                    ['step' => 2, 'title' => 'Programme Development', 'description' => 'We draft or update radiation safety policies, contingency plans, and staff role definitions aligned with best practice.'],
                    ['step' => 3, 'title' => 'Shielding & Dose Review', 'description' => 'We verify shielding calculations, assess occupational and public dose estimates, and recommend improvements where needed.'],
                    ['step' => 4, 'title' => 'Inspection Preparation', 'description' => 'We conduct mock audits and prepare your team for regulatory inspections with structured evidence packs.'],
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'deliverables' => json_encode([
                    'Radiation safety compliance audit report',
                    'Updated local rules and standard operating procedures',
                    'Shielding assessment review and recommendations',
                    'Risk assessment documentation',
                    'Inspection readiness checklist and evidence index',
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'benefits' => '<p>Proactive compliance management prevents enforcement actions, reduces occupational exposure, and builds a culture of safety. We help you stay ahead of regulatory changes rather than scrambling to catch up.</p>',
                'meta_title' => 'Radiation Safety & Compliance Consulting | Radiation Equipment Consultancy',
                'meta_description' => 'Radiation safety programme design, shielding review, and regulatory inspection preparation for hospitals and imaging centres worldwide.',
                'sort_order' => 6,
            ],
            [
                'slug' => 'quality-assurance-dosimetry',
                'title' => 'Quality Assurance & Dosimetry Services',
                'icon' => 'fa-chart-line',
                'short_description' => 'Clinical dosimetry, QA protocol development, and periodic testing for radiation equipment programmes.',
                'intro' => '<p>Ongoing quality assurance is essential to maintain the accuracy and safety of radiation equipment throughout its operational life. We provide dosimetry services, QA protocol design, and periodic testing support for radiotherapy, diagnostic imaging, and nuclear medicine departments.</p>',
                'challenge' => '<p>QA programmes often become inconsistent over time — protocols go out of date, equipment drifts undetected, and staff lack time or expertise to perform comprehensive checks. Regulatory bodies and accreditation organisations increasingly demand documented, risk-based QA with traceable results.</p>',
                'approach' => json_encode([
                    ['step' => 1, 'title' => 'QA Programme Review', 'description' => 'We assess your current QA protocols, test frequencies, and historical results against current standards and manufacturer guidance.'],
                    ['step' => 2, 'title' => 'Protocol Optimisation', 'description' => 'We design risk-based QA schedules with clear acceptance criteria, action levels, and documentation templates.'],
                    ['step' => 3, 'title' => 'Dosimetry & Testing', 'description' => 'We perform independent dosimetry audits, image quality assessments, and mechanical checks using calibrated equipment.'],
                    ['step' => 4, 'title' => 'Trend Analysis & Reporting', 'description' => 'We analyse results over time, identify emerging issues, and recommend corrective or preventive actions.'],
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'deliverables' => json_encode([
                    'QA programme assessment report',
                    'Revised QA protocols and test record templates',
                    'Dosimetry audit results with uncertainty analysis',
                    'Image quality and mechanical test reports',
                    'Annual QA summary with trend analysis',
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'benefits' => '<p>Robust QA programmes catch problems before they affect patients, satisfy accreditation requirements, and extend equipment useful life. We bring objectivity and depth that complements your in-house physics and engineering teams.</p>',
                'meta_title' => 'Quality Assurance & Dosimetry Services | Radiation Equipment Consultancy',
                'meta_description' => 'Clinical dosimetry audits, QA protocol development, and periodic testing for linacs, CT scanners, and nuclear medicine systems.',
                'sort_order' => 7,
            ],
            [
                'slug' => 'equipment-relocation-decommissioning',
                'title' => 'Equipment Relocation & Decommissioning',
                'icon' => 'fa-truck-moving',
                'short_description' => 'Safe, compliant relocation of radiation equipment and structured decommissioning of end-of-life systems.',
                'intro' => '<p>Whether you are moving equipment between sites, upgrading to new technology, or retiring legacy systems, radiation equipment relocation and decommissioning require specialist planning. We manage the technical, regulatory, and safety aspects so your transition is smooth and fully documented.</p>',
                'challenge' => '<p>Relocation projects risk equipment damage, extended downtime, and loss of calibration data. Decommissioning of radiation sources and activated components involves strict regulatory notification, specialised contractors, and potential radioactive waste management — mistakes can result in significant fines and reputational harm.</p>',
                'approach' => json_encode([
                    ['step' => 1, 'title' => 'Feasibility & Planning', 'description' => 'We assess whether relocation is technically and economically viable, or whether decommissioning is the better option.'],
                    ['step' => 2, 'title' => 'Regulatory Notification', 'description' => 'We prepare and submit required notifications to radiation safety authorities for movement, disposal, or site clearance.'],
                    ['step' => 3, 'title' => 'Execution Oversight', 'description' => 'We supervise disconnection, transport, reinstallation, or dismantling activities with full safety protocols.'],
                    ['step' => 4, 'title' => 'Site Clearance & Records', 'description' => 'We verify dose rates for decommissioned areas and compile complete records for regulatory closure.'],
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'deliverables' => json_encode([
                    'Relocation or decommissioning project plan',
                    'Regulatory notification and correspondence file',
                    'Pre- and post-move acceptance test results',
                    'Radiation survey reports for cleared areas',
                    'Final decommissioning certificate and waste disposal records',
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'benefits' => '<p>Properly managed relocation preserves equipment value and minimises clinical downtime. Structured decommissioning ensures regulatory closure and frees facility space for new investments without legacy liability.</p>',
                'meta_title' => 'Equipment Relocation & Decommissioning | Radiation Equipment Consultancy',
                'meta_description' => 'Safe relocation and regulatory-compliant decommissioning of linacs, CT scanners, and nuclear medicine equipment. Full documentation and site clearance.',
                'sort_order' => 8,
            ],
            [
                'slug' => 'preventive-maintenance-support',
                'title' => 'Preventive Maintenance & Technical Support',
                'icon' => 'fa-wrench',
                'short_description' => 'Independent preventive maintenance planning and technical advisory to maximise equipment uptime and lifespan.',
                'intro' => '<p>Reactive maintenance is costly and disruptive. We help facilities implement preventive maintenance strategies and provide independent technical support that complements manufacturer service contracts, ensuring your radiation equipment remains reliable and clinically available.</p>',
                'challenge' => '<p>Many facilities rely solely on vendor service agreements without independent oversight of maintenance quality or frequency. In-house biomedical teams may lack modality-specific expertise, leading to missed early warning signs, unplanned failures, and extended patient scheduling disruptions.</p>',
                'approach' => json_encode([
                    ['step' => 1, 'title' => 'Maintenance Programme Audit', 'description' => 'We review existing PM schedules, service contract scope, and historical failure data to identify gaps and risks.'],
                    ['step' => 2, 'title' => 'Optimised PM Planning', 'description' => 'We develop risk-based preventive maintenance plans with clear tasks, intervals, and spare parts recommendations.'],
                    ['step' => 3, 'title' => 'Technical Advisory Support', 'description' => 'We provide on-call expert advice for troubleshooting, vendor escalation, and root cause analysis of recurring issues.'],
                    ['step' => 4, 'title' => 'Performance Monitoring', 'description' => 'We track uptime, mean time between failures, and maintenance costs to demonstrate programme effectiveness.'],
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'deliverables' => json_encode([
                    'Preventive maintenance programme assessment',
                    'Optimised PM schedule and task checklists',
                    'Spare parts and consumables recommendations',
                    'Technical support log and incident reports',
                    'Quarterly equipment performance summary',
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'benefits' => '<p>Effective preventive maintenance reduces emergency repairs, extends equipment life, and improves patient access. We give your engineering team an independent expert resource they can trust.</p>',
                'meta_title' => 'Preventive Maintenance & Technical Support | Radiation Equipment Consultancy',
                'meta_description' => 'Independent PM planning and technical advisory for radiation equipment. We maximise uptime for linacs, imaging systems, and nuclear medicine devices.',
                'sort_order' => 9,
            ],
            [
                'slug' => 'regulatory-documentation-licensing',
                'title' => 'Regulatory Documentation & Licensing Support',
                'icon' => 'fa-file-contract',
                'short_description' => 'Expert preparation of regulatory submissions, licence applications, and compliance documentation.',
                'intro' => '<p>Navigating the regulatory landscape for radiation equipment can be daunting. We prepare and review the documentation required for new licences, amendments, renewals, and regulatory notifications — ensuring your submissions are complete, accurate, and persuasive.</p>',
                'challenge' => '<p>Regulatory applications are often rejected or delayed due to incomplete shielding data, inadequate risk assessments, or inconsistent technical descriptions. Hospital staff may lack the time or specialist knowledge to compile submissions that meet the exacting standards of radiation safety authorities.</p>',
                'approach' => json_encode([
                    ['step' => 1, 'title' => 'Regulatory Requirements Mapping', 'description' => 'We identify all applicable licences, permits, and notifications for your equipment type and jurisdiction.'],
                    ['step' => 2, 'title' => 'Document Compilation', 'description' => 'We gather and format technical data, shielding reports, floor plans, and safety policies into submission-ready packages.'],
                    ['step' => 3, 'title' => 'Review & Quality Assurance', 'description' => 'We perform internal QA on all documentation for consistency, completeness, and regulatory alignment before submission.'],
                    ['step' => 4, 'title' => 'Authority Liaison', 'description' => 'We respond to regulator queries, attend meetings if required, and track application progress to approval.'],
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'deliverables' => json_encode([
                    'Regulatory requirements checklist',
                    'Complete licence application packages',
                    'Shielding and safety case documentation',
                    'Correspondence log with regulatory authority',
                    'Approved licence copies and compliance register',
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'benefits' => '<p>Professional regulatory documentation accelerates approval timelines and reduces the risk of enforcement action. We speak the language of regulators and know what evidence they expect to see.</p>',
                'meta_title' => 'Regulatory Documentation & Licensing | Radiation Equipment Consultancy',
                'meta_description' => 'Radiation equipment licence applications, regulatory submissions, and compliance documentation prepared by experienced consultants.',
                'sort_order' => 10,
            ],
            [
                'slug' => 'clinical-program-optimisation',
                'title' => 'Clinical Program Review & Optimisation',
                'icon' => 'fa-hospital',
                'short_description' => 'Strategic review and optimisation of clinical radiation programmes for efficiency, safety, and quality outcomes.',
                'intro' => '<p>Beyond equipment, the effectiveness of a radiation service depends on clinical workflows, staffing models, and quality systems. We conduct holistic programme reviews to help departments optimise throughput, reduce errors, and align operations with best practice and accreditation standards.</p>',
                'challenge' => '<p>Departments under pressure to treat more patients often sacrifice process rigour, leading to near-misses, staff burnout, and accreditation findings. Without an external perspective, inefficiencies and safety culture gaps can persist despite investment in new technology.</p>',
                'approach' => json_encode([
                    ['step' => 1, 'title' => 'Programme Assessment', 'description' => 'We evaluate clinical workflows, staffing, equipment utilisation, QA integration, and patient safety incident trends.'],
                    ['step' => 2, 'title' => 'Benchmarking & Gap Analysis', 'description' => 'We compare your programme against peer facilities and accreditation standards to identify improvement opportunities.'],
                    ['step' => 3, 'title' => 'Optimisation Roadmap', 'description' => 'We develop prioritised recommendations with implementation timelines, resource needs, and expected outcomes.'],
                    ['step' => 4, 'title' => 'Implementation Support', 'description' => 'We assist with change management, staff engagement, and progress monitoring during improvement initiatives.'],
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'deliverables' => json_encode([
                    'Clinical programme assessment report',
                    'Workflow analysis with bottleneck identification',
                    'Benchmarking comparison and gap analysis',
                    'Prioritised optimisation roadmap',
                    'Implementation progress review at agreed milestones',
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'benefits' => '<p>Programme optimisation improves patient access, staff satisfaction, and accreditation readiness. We help you get more value from your existing equipment and team without compromising safety.</p>',
                'meta_title' => 'Clinical Program Optimisation | Radiation Equipment Consultancy',
                'meta_description' => 'Strategic review and optimisation of radiotherapy, imaging, and nuclear medicine programmes. We improve efficiency, safety, and clinical outcomes.',
                'sort_order' => 11,
            ],
        ];
    }

    private static function seedEquipment(PDO $pdo): void
    {
        $pdo->exec('DELETE FROM equipment');

        $items = [
            ['Radiotherapy', 'Linear Accelerators (Linacs)', 'fa-radiation', 'External beam photon and electron therapy systems including conventional, stereotactic, and VMAT-capable platforms.', 1],
            ['Radiotherapy', 'Gamma Knife', 'fa-brain', 'Stereotactic radiosurgery systems for intracranial lesions with sub-millimetre targeting precision.', 2],
            ['Radiotherapy', 'Proton Therapy', 'fa-atom', 'Cyclotron and synchrotron-based proton beam systems for deep-seated tumours and paediatric applications.', 3],
            ['Radiotherapy', 'SGRT (Surface-Guided Radiotherapy)', 'fa-person-rays', 'Optical surface monitoring and gating systems for motion management during radiotherapy delivery.', 4],
            ['Diagnostic Radiology', 'CT Scanners', 'fa-circle-radiation', 'Single-source, dual-source, and spectral CT systems for diagnostic and interventional imaging.', 1],
            ['Diagnostic Radiology', 'X-ray Systems', 'fa-x-ray', 'Fixed and mobile general radiography systems including DR detectors and bucky configurations.', 2],
            ['Diagnostic Radiology', 'Mammography', 'fa-ribbon', 'Full-field digital mammography and tomosynthesis systems for breast screening and diagnostics.', 3],
            ['Diagnostic Radiology', 'Fluoroscopy', 'fa-display', 'C-arm, R/F rooms, and interventional fluoroscopy systems for real-time guided procedures.', 4],
            ['Nuclear Medicine', 'Gamma Cameras', 'fa-camera', 'Anger camera and solid-state SPECT systems for planar and tomographic nuclear medicine imaging.', 1],
            ['Nuclear Medicine', 'PET-CT', 'fa-dna', 'Integrated positron emission tomography and CT systems for oncology, cardiology, and neurology.', 2],
            ['Nuclear Medicine', 'SPECT', 'fa-circle-nodes', 'Single photon emission computed tomography systems including SPECT-CT hybrid configurations.', 3],
        ];

        $stmt = $pdo->prepare(
            'INSERT INTO equipment (category, name, description, icon, sort_order, is_published)
             VALUES (?, ?, ?, ?, ?, 1)'
        );

        foreach ($items as $item) {
            // Order: category, name, description, icon, sort_order
            $stmt->execute([$item[0], $item[1], $item[3], $item[2], $item[4]]);
        }
    }

    private static function seedBlogCategories(PDO $pdo): void
    {
        $categories = [
            ['Industry Insights', 'industry-insights'],
            ['Technical Guides', 'technical-guides'],
            ['Regulatory Updates', 'regulatory-updates'],
        ];

        $stmt = $pdo->prepare(
            'INSERT INTO blog_categories (name, slug)
             VALUES (?, ?)
             ON DUPLICATE KEY UPDATE name = VALUES(name)'
        );

        foreach ($categories as $category) {
            $stmt->execute($category);
        }
    }

    private static function getCategoryId(PDO $pdo, string $slug): ?int
    {
        $stmt = $pdo->prepare('SELECT id FROM blog_categories WHERE slug = ?');
        $stmt->execute([$slug]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? (int) $row['id'] : null;
    }

    private static function seedBlogPosts(PDO $pdo): void
    {
        $posts = [
            [
                'category_slug' => 'technical-guides',
                'slug' => 'linac-commissioning-best-practices',
                'title' => 'Linac Commissioning Best Practices: What Every Cancer Centre Should Know',
                'excerpt' => 'A practical guide to independent linac commissioning — from protocol selection through clinical release documentation.',
                'content' => self::blogLinacCommissioning(),
                'meta_title' => 'Linac Commissioning Best Practices | Radiation Equipment Consultancy Blog',
                'meta_description' => 'Essential commissioning steps for linear accelerators. We explain independent verification, dosimetry baselines, and regulatory documentation.',
                'published_at' => '2026-03-15 09:00:00',
            ],
            [
                'category_slug' => 'technical-guides',
                'slug' => 'ct-scanner-installation-planning',
                'title' => 'Planning a CT Scanner Installation: Site Readiness and Common Pitfalls',
                'excerpt' => 'How we help hospitals avoid costly delays when installing new CT systems — from shielding to HVAC and workflow design.',
                'content' => self::blogCtInstallation(),
                'meta_title' => 'CT Scanner Installation Planning Guide | Radiation Equipment Consultancy Blog',
                'meta_description' => 'Site readiness checklist for CT scanner installations. Shielding, utilities, and vendor coordination explained by our engineering team.',
                'published_at' => '2026-04-02 09:00:00',
            ],
            [
                'category_slug' => 'regulatory-updates',
                'slug' => 'radiation-safety-compliance-hospitals',
                'title' => 'Radiation Safety Compliance for Hospitals: Staying Ahead of Regulatory Changes',
                'excerpt' => 'Key compliance obligations for radiation-producing equipment and how we help facilities prepare for successful inspections.',
                'content' => self::blogRadiationSafety(),
                'meta_title' => 'Hospital Radiation Safety Compliance | Radiation Equipment Consultancy Blog',
                'meta_description' => 'Regulatory compliance guidance for hospital radiation programmes. Local rules, risk assessments, and inspection preparation.',
                'published_at' => '2026-05-10 09:00:00',
            ],
            [
                'category_slug' => 'industry-insights',
                'slug' => 'nuclear-medicine-equipment-qa',
                'title' => 'Quality Assurance in Nuclear Medicine: Building a Sustainable Equipment Programme',
                'excerpt' => 'Why nuclear medicine QA requires a modality-specific approach — and how we help departments maintain consistent testing standards.',
                'content' => self::blogNuclearMedicineQa(),
                'meta_title' => 'Nuclear Medicine Equipment QA | Radiation Equipment Consultancy Blog',
                'meta_description' => 'QA programme design for gamma cameras, PET-CT, and SPECT systems. Practical advice from our nuclear medicine consultants.',
                'published_at' => '2026-06-01 09:00:00',
            ],
        ];

        $stmt = $pdo->prepare(
            'INSERT INTO blog_posts (category_id, slug, title, excerpt, content, meta_title, meta_description, is_published, published_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?)
             ON DUPLICATE KEY UPDATE
                category_id = VALUES(category_id),
                title = VALUES(title),
                excerpt = VALUES(excerpt),
                content = VALUES(content),
                meta_title = VALUES(meta_title),
                meta_description = VALUES(meta_description),
                is_published = VALUES(is_published),
                published_at = VALUES(published_at)'
        );

        foreach ($posts as $post) {
            $categoryId = self::getCategoryId($pdo, $post['category_slug']);
            $stmt->execute([
                $categoryId,
                $post['slug'],
                $post['title'],
                $post['excerpt'],
                $post['content'],
                $post['meta_title'],
                $post['meta_description'],
                $post['published_at'],
            ]);
        }
    }

    private static function blogLinacCommissioning(): string
    {
        return <<<'HTML'
<p>Commissioning a linear accelerator is among the most consequential activities in any radiotherapy department. It is the process through which we verify that a complex, high-energy system is safe, accurate, and ready for clinical use. Yet commissioning scope varies significantly between vendors, and many facilities lack the in-house medical physics capacity to verify results independently. This gap is where problems begin — and where a structured, evidence-based approach makes the difference.</p>
<p>We begin every linac commissioning engagement by defining protocols aligned with international standards such as IAEA TRS-430, AAPM Task Group reports, and the manufacturer's own acceptance criteria. We do not simply witness vendor testing; we perform independent measurements using calibrated ionisation chambers, water phantoms, and electronic portal imaging devices. This dual-track approach ensures that beam data, mechanical isocentre, MLC positioning, and safety interlocks are verified from two independent perspectives before clinical release.</p>
<p>One of the most common issues we encounter is incomplete documentation. Commissioning generates enormous volumes of data — beam profiles, output factors, wedge factors, imaging chain QA, and mechanical tolerances. Without a structured documentation framework, critical results are scattered across vendor reports, email threads, and handwritten notes. We compile a commissioning dossier designed for regulatory submission and clinical governance review, with clear traceability from raw measurements to acceptance decisions.</p>
<p>For facilities commissioning their first linac or upgrading to a new platform, we recommend engaging independent consultancy support before the vendor arrives on site. Early involvement allows us to review bunker readiness, confirm dosimetry equipment calibration, and align your physics team on roles and responsibilities. The result is a smoother commissioning timeline, fewer surprises at acceptance, and a QA baseline that supports your department for years to come.</p>
HTML;
    }

    private static function blogCtInstallation(): string
    {
        return <<<'HTML'
<p>Installing a new CT scanner should be straightforward — the vendor delivers, connects, and commissions the system. In practice, we see installations delayed by weeks because fundamental site readiness issues were not addressed early enough. Inadequate floor reinforcement, incorrect door dimensions, insufficient cooling capacity, or shielding that does not match the scanner's peak kilovoltage are among the most frequent causes of project overruns we encounter across hospital projects worldwide.</p>
<p>Our site readiness methodology starts with a detailed review of the manufacturer's installation manual against the as-built construction drawings. We verify floor load ratings, ceiling height for gantry rotation, cable trench routing, and radiation shielding calculations that account for the specific scanner model and expected workload. We also assess workflow design — patient access, control room sightlines, and injector placement — because a technically correct installation can still fail operationally if clinical staff cannot work efficiently.</p>
<p>Coordination between the hospital's civil contractors, MEP engineers, IT department, and the CT vendor is another critical success factor. We establish a responsibility matrix and integrated timeline so that each party knows exactly what must be complete before the next phase begins. When we manage this coordination, vendor standby charges — which can exceed thousands of pounds per day — are minimised, and the hospital avoids the reputational impact of a publicly visible project delay.</p>
<p>Whether you are installing a replacement scanner in an existing suite or building a new imaging department, we recommend a pre-installation audit at least eight weeks before the scheduled delivery date. This gives sufficient time to address any gaps without compressing the commissioning window. The modest investment in early oversight consistently saves far more in avoided rework and accelerated clinical go-live.</p>
HTML;
    }

    private static function blogRadiationSafety(): string
    {
        return <<<'HTML'
<p>Radiation safety compliance is not a static achievement — it is an ongoing obligation that evolves as equipment changes, staff turnover occurs, and regulatory frameworks are updated. Hospitals operating CT scanners, fluoroscopy suites, nuclear medicine departments, and radiotherapy bunkers face a complex web of licensing requirements, local rules, risk assessments, and inspection schedules. We work with facilities across multiple jurisdictions and see consistent patterns in where compliance programmes fall short.</p>
<p>The most frequent gaps we identify during compliance audits relate to documentation currency. Local rules that reference decommissioned equipment, risk assessments that have not been reviewed after a major workflow change, and shielding reports that pre-date room modifications are common findings. Regulators are increasingly sophisticated in their inspections — they expect evidence of a living safety programme, not a folder of documents created once and never updated.</p>
<p>We recommend a structured compliance calendar that maps every regulatory obligation to a responsible person, review frequency, and evidence requirement. This includes licence renewal dates, training refreshers, equipment QA schedules, incident reporting protocols, and emergency drill records. When we implement this framework for clients, inspection outcomes improve dramatically — not because the underlying safety practices change overnight, but because the evidence of those practices is organised and accessible.</p>
<p>For facilities expanding into new modalities — such as a hospital adding its first PET-CT or a clinic introducing fluoroscopy-guided procedures — early regulatory engagement is essential. We help prepare licence applications, shielding safety cases, and notification submissions that meet authority expectations the first time. Proactive compliance is always less expensive and less stressful than remedial action after an enforcement notice.</p>
HTML;
    }

    private static function blogNuclearMedicineQa(): string
    {
        return <<<'HTML'
<p>Nuclear medicine departments operate some of the most technically diverse equipment in a hospital — gamma cameras, SPECT systems, PET-CT scanners, dose calibrators, and automated synthesis units each require distinct QA protocols. Yet we frequently find that NM departments apply generic testing schedules that do not reflect modality-specific risks or manufacturer recommendations, leading to undetected performance drift and accreditation findings.</p>
<p>Effective nuclear medicine QA begins with a risk-based protocol design. For gamma cameras, this means regular uniformity, resolution, and energy window checks with appropriate phantoms. PET-CT systems require attention to both the nuclear and CT components — NEMA NU-2 performance metrics, SUV reproducibility, and CT dose index verification must all be part of a coherent programme. We design protocols that balance testing rigour with operational practicality, because a QA programme that staff cannot sustain is worse than no programme at all.</p>
<p>Staff competency is equally important. Nuclear medicine technologists are often expected to perform complex QA procedures with limited physics support. We provide training that explains not just how to run tests, but why each measurement matters and what action levels trigger escalation. This builds a culture where QA is understood as a patient safety activity, not an administrative burden.</p>
<p>As molecular imaging continues to expand — with new radiotracers, theranostic applications, and hybrid system configurations — QA programmes must evolve accordingly. We help departments review their protocols annually, incorporate new international guidance, and prepare documentation for accreditation surveys. A sustainable NM QA programme is an investment in diagnostic confidence and regulatory peace of mind.</p>
HTML;
    }

    private static function seedTestimonials(PDO $pdo): void
    {
        $pdo->exec('DELETE FROM testimonials');

        $testimonials = [
            [
                'Dr. Amara Okafor',
                'Lagos University Teaching Hospital',
                'Head of Radiotherapy Physics',
                'We engaged Radiation Equipment Consultancy to oversee the installation and commissioning of our first linear accelerator. Their team identified shielding deficiencies and utility shortfalls three months before vendor delivery, saving us an estimated six weeks of delay. The independent commissioning verification gave our regulators confidence and our clinicians peace of mind.',
                'Commissioning completed 6 weeks ahead of revised schedule',
                5,
                1,
            ],
            [
                'James Whitfield',
                'Mercy Regional Medical Centre',
                'Director of Biomedical Engineering',
                'When we needed to relocate two CT scanners during a major department refurbishment, Radiation Equipment Consultancy managed the entire process — regulatory notifications, vendor coordination, and post-move acceptance testing. Both systems were clinically operational within the planned window with zero unplanned downtime for emergency imaging.',
                'Zero unplanned imaging downtime during relocation',
                5,
                2,
            ],
            [
                'Dr. Fatima Al-Rashid',
                'Gulf Oncology Institute',
                'Chief Medical Physicist',
                'Radiation Equipment Consultancy conducted a comprehensive radiation safety compliance audit ahead of our regulatory inspection. They rewrote our local rules, updated risk assessments, and trained our staff on new procedures. We passed inspection with no major findings — the first time in our department\'s history.',
                'First inspection passed with zero major findings',
                5,
                3,
            ],
        ];

        $stmt = $pdo->prepare(
            'INSERT INTO testimonials (client_name, organization, role, content, outcome_metric, rating, is_published, sort_order)
             VALUES (?, ?, ?, ?, ?, ?, 1, ?)'
        );

        foreach ($testimonials as $testimonial) {
            $stmt->execute($testimonial);
        }
    }

    private static function seedSeo(PDO $pdo): void
    {
        $entries = [
            [
                'home',
                'Radiation Equipment Consultancy | Radiation Equipment Experts',
                'Independent consultancy for radiation equipment installation, commissioning, and compliance. We support hospitals and cancer centres worldwide.',
                'radiation equipment consultancy, medical physics, linac commissioning, hospital equipment installation',
            ],
            [
                'about',
                'About Us | Radiation Equipment Consultancy',
                'Meet our team of medical physicists and biomedical engineers. We provide independent radiation equipment expertise with a safety-first philosophy.',
                'radiation consultancy team, medical physicists, biomedical engineers, radiation safety',
            ],
            [
                'services',
                'Our Services | Radiation Equipment Consultancy',
                'Eleven specialist consultancy services covering installation, commissioning, training, project management, radiation safety, and clinical programme optimisation.',
                'radiation equipment services, commissioning, installation, staff training, regulatory compliance',
            ],
            [
                'equipment',
                'Equipment Expertise | Radiation Equipment Consultancy',
                'Technical expertise across radiotherapy, diagnostic radiology, and nuclear medicine equipment including linacs, CT, PET-CT, and gamma cameras.',
                'linac expertise, CT scanner, PET-CT, gamma camera, radiation equipment',
            ],
            [
                'blog',
                'Resources & Insights | Radiation Equipment Consultancy',
                'Technical guides, industry insights, and regulatory updates on radiation equipment installation, commissioning, and quality assurance.',
                'radiation equipment blog, commissioning guide, radiation safety, nuclear medicine QA',
            ],
            [
                'contact',
                'Contact Us | Radiation Equipment Consultancy',
                'Request a consultation for your radiation equipment project. We respond to all enquiries within 24 hours on business days.',
                'contact radiation consultant, equipment consultancy enquiry, radiation equipment consultancy contact',
            ],
            [
                'privacy',
                'Privacy Policy | Radiation Equipment Consultancy',
                'How we collect, use, and protect your personal information when you use our website or contact us for consultancy services.',
                'privacy policy, data protection, radiation equipment consultancy',
            ],
            [
                'terms',
                'Terms of Use | Radiation Equipment Consultancy',
                'Terms governing your use of the Radiation Equipment Consultancy website and informational content.',
                'terms of use, website terms, radiation equipment consultancy',
            ],
        ];

        $stmt = $pdo->prepare(
            'INSERT INTO seo (page_key, meta_title, meta_description, meta_keywords)
             VALUES (?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE
                meta_title = VALUES(meta_title),
                meta_description = VALUES(meta_description),
                meta_keywords = VALUES(meta_keywords)'
        );

        foreach ($entries as $entry) {
            $stmt->execute($entry);
        }
    }
}
