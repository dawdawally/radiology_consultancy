# Development Plan — Radiation Equipment Consultancy Website

**Version:** 1.1  
**Date:** July 2026  
**Status:** Planning

---

## 1. Document Hierarchy & Source of Truth

This project uses **two authoritative document sets**. When they overlap, each set governs its own domain.

### Business & Content (what to build)

| Document | Governs |
|----------|---------|
| **`Business_Requirements.pdf`** | Services, messaging, sitemap, page content structure, SEO keywords, launch expectations, and go-to-market strategy |

### Technical Stack & Implementation (how to build)

| Document | Governs |
|----------|---------|
| **`Project Structure.pdf` → Solution Design Document (SDD)** | Architecture, functional modules, CMS philosophy, security, performance, and workflows |
| **`Project Structure.pdf` → Technical Design Document (TDD)** | Tech stack, folder structure, database schema, coding standards, components, and naming conventions |
| **`Project Structure.pdf` → Project Brief & Master Prompt** | Project constraints, implementation order, and quality bar |

**Platform decision:** This is a **custom PHP 8 + MySQL + Bootstrap 5** application deployed on Hostinger. **WordPress is not used.** Any CMS, hosting, or platform recommendations in the Business Requirements (e.g. managed WordPress hosting, WordPress plugins) are **out of scope and must be ignored**. The SDD and TDD are the sole source of truth for all technical and architectural decisions.

---

## 2. Project Vision

Build a professional, CMS-driven consultancy website for an independent radiation equipment consultant. The site must:

- Position the consultant as a trusted technical partner for hospitals, cancer centres, and diagnostic imaging facilities worldwide
- Showcase core and expanded service offerings with clear CTAs
- Demonstrate equipment expertise across radiotherapy, diagnostic radiology, and nuclear medicine
- Capture leads via contact forms and consultation requests
- Allow all business content to be managed from an Admin Dashboard without code changes

**Explicitly out of scope:** E-commerce, hospital management, client accounts, public registration.

---

## 3. Technology Stack

*Authoritative source: TDD + SDD + Project Brief. Not WordPress or any third-party CMS.*

| Layer | Choice | Source |
|-------|--------|--------|
| Frontend | HTML5, Bootstrap 5, CSS3, Vanilla JavaScript, FontAwesome, AOS | TDD / Project Brief |
| Backend | PHP 8.x (OOP, MVC-inspired, PDO only) | TDD |
| Database | MySQL | TDD |
| Hosting | Hostinger (Apache) | Project Brief |
| Admin UI | Bootstrap 5, dark sidebar, light content area | TDD |
| Public UI | White/blue medical theme, rounded cards, AOS animations | TDD |
| Responsive breakpoints | 576 / 768 / 992 / 1200+ | TDD |

**Explicitly excluded:** WordPress, PHP frameworks (Laravel, Symfony, etc.), JavaScript frameworks (React, Vue, etc.), mysqli, hardcoded business content.

---

## 4. Architecture Overview

```
Browser (Public Site)          Browser (Admin Dashboard)
        │                                │
        └──────────┬─────────────────────┘
                   ▼
            PHP Application
         (controllers / models / views)
                   │
                   ▼
              MySQL Database
```

**Two components, one database:**

1. **Public Website** — read-only content display, contact form submission, blog
2. **Admin Dashboard** — authenticated CRUD for all content, media, SEO, and messages

**CMS principle:** Layout is fixed; all headings, paragraphs, images, buttons, services, testimonials, and SEO metadata come from the database. No hardcoded business content in HTML.

---

## 5. Scope Mapping — Business Requirements → System Modules

### 5.1 Public Pages (from SDD + Business Requirements sitemap)

| Page | Business Requirements Source | CMS Module |
|------|------------------------------|------------|
| Home | Hero, problem/solution, service preview, CTA | Homepage Manager |
| About | Background, qualifications, certifications, safety philosophy | About Manager |
| Services (overview + detail) | 11 service categories (see §5.2) | Service Manager |
| Equipment Expertise | Radiotherapy, Diagnostic Radiology, Nuclear Medicine sub-categories | Equipment Manager |
| Case Studies / Testimonials | Client success stories, measurable outcomes | Testimonials Manager |
| Blog / Resources | Educational articles, industry insights | Blog Manager |
| Contact | Form, phone, email, 24-hour response commitment | Website Settings + Messages |
| Privacy | Legal (SDD) | Website Settings or static legal page with CMS text |
| Terms | Legal (SDD) | Website Settings or static legal page with CMS text |
| 404 | Error handling | Static template |

### 5.2 Service Categories (seed content from Business Requirements)

**Core services (§2):**

1. Installation Services  
2. Commissioning & Acceptance Testing  
3. Staff Training  

**Expanded services (§3):**

4. Pre-Purchase Consultation & Equipment Selection  
5. Project Management for Equipment Projects  
6. Radiation Safety & Regulatory Compliance  
7. Quality Assurance & Dosimetry Services  
8. Equipment Relocation & Decommissioning  
9. Preventive Maintenance & Technical Support  
10. Regulatory Documentation & Licensing Support  
11. Clinical Program Review & Optimisation  

Each service detail page follows the BR template: intro, challenge, approach (steps), deliverables, benefits, CTA ("Request a Consultation").

### 5.3 Equipment Expertise (seed content from Business Requirements §4.1)

| Category | Equipment Types |
|----------|-----------------|
| Radiotherapy | Linacs, Gamma Knife, Proton Therapy, SGRT |
| Diagnostic Radiology | CT, X-ray, Mammography, Fluoroscopy |
| Nuclear Medicine | Gamma Cameras, PET-CT, SPECT |

### 5.4 Homepage Sections (SDD §Website Sections)

Hero → About Preview → Services → Equipment → Why Choose Us → Process → CTA → Footer — each section editable via Homepage Manager.

### 5.5 Core Messaging (Business Requirements §5.1)

All copy should reinforce: Safety First, Regulatory Expertise, Technical Authority, Client Partnership, Global Reach.

---

## 6. Database Schema (from TDD)

Initial tables to implement in Phase 1:

| Table | Purpose |
|-------|---------|
| `admin_users` | Administrator accounts (hashed passwords, roles) |
| `website_settings` | Site name, contact info, social links, response-time commitment |
| `homepage` | Section-based homepage content (hero, previews, CTAs) |
| `about` | About page sections (bio, qualifications, certifications, philosophy) |
| `services` | Service records with slug, title, body sections, SEO fields, sort order |
| `equipment` | Equipment categories and items |
| `blog_categories` | Blog taxonomy |
| `blog_posts` | Articles with publish status, SEO metadata |
| `testimonials` | Case studies / client quotes with optional metrics |
| `messages` | Contact form submissions |
| `seo` | Global and per-page SEO overrides |
| `media` | Media library metadata (filename, alt text, dimensions) |
| `activity_logs` | Admin audit trail |

**Naming:** `snake_case` for database columns and tables.

---

## 7. Folder Structure (from TDD)

```
/
├── admin/
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── uploads/
├── includes/
│   ├── config/
│   ├── database/
│   ├── controllers/
│   ├── models/
│   └── views/
├── api/
└── index.php
```

**Shared includes:** `header.php`, `navbar.php`, `footer.php`, `sidebar.php`, `db.php`, `auth.php`, `functions.php`

---

## 8. Phased Development Plan

Implementation follows the Master Prompt order: foundation first, then CMS modules. **Each phase must leave the application fully functional before proceeding.**

---

### Phase 0 — Project Setup & Planning

**Goal:** Establish repo, environment, and baseline documentation.

| Task | Deliverable |
|------|-------------|
| Initialize project folder structure per TDD | Scaffolded directories |
| Set up local dev environment (PHP 8, MySQL, Apache) | Working localhost |
| Create `.env` / config pattern for DB credentials | `includes/config/` |
| Document environment setup for Hostinger deployment | README (optional) |
| Finalize this development plan | `development plan.md` ✓ |

**Exit criteria:** Empty scaffold runs; DB connection test passes.

---

### Phase 1 — Foundation (Database, Config, Auth, Layout Shells)

**Goal:** Core infrastructure both public and admin can build on.

| # | Task | Details |
|---|------|---------|
| 1.1 | Database schema | SQL migration script for all 13 tables; indexes on slugs, foreign keys |
| 1.2 | PDO database layer | `db.php`, base Model class, prepared statements only |
| 1.3 | Reusable functions | `functions.php` — sanitization, slugify, redirect, flash messages |
| 1.4 | Authentication | Login/logout, session management, password hashing (`password_hash`), CSRF tokens |
| 1.5 | Admin layout shell | Dark sidebar, light content area, Bootstrap 5, toast notifications |
| 1.6 | Public layout shell | Navbar, footer, breadcrumbs, medical theme CSS variables |
| 1.7 | Routing / entry points | `index.php` front controller pattern; `admin/` entry |
| 1.8 | Seed admin user | Initial administrator account via migration |

**Security checklist:** Prepared statements, CSRF on forms, XSS escaping in views, session hardening.

**Exit criteria:** Admin can log in/out; public site shows layout with placeholder dynamic slots; no business copy hardcoded.

---

### Phase 2 — Admin Dashboard Core & Shared Backend

**Goal:** Reusable CRUD engine and media handling used by all CMS modules.

| # | Task | Details |
|---|------|---------|
| 2.1 | Dashboard home | Summary widgets: recent messages, draft posts, activity |
| 2.2 | CRUD engine | Generic list/create/edit/delete with Bootstrap tables, modals, pagination |
| 2.3 | Media library | Upload (jpg/jpeg/png/webp, max 5MB), unique filenames, `uploads/` storage |
| 2.4 | Image picker integration | Select from media library in all content forms |
| 2.5 | SEO manager | Global defaults + per-entity meta title/description |
| 2.6 | Website settings | Contact details, social links, footer text, legal snippets |
| 2.7 | Admin profile | Change password, update profile |
| 2.8 | Activity logging | Log create/update/delete actions |

**Exit criteria:** Media upload works; settings persist; CRUD patterns proven on one pilot entity.

---

### Phase 3 — Public Website Pages (Static Layout, Dynamic Content)

**Goal:** All public pages render from database.

| # | Task | Page / Feature |
|---|------|----------------|
| 3.1 | Homepage | All 8 sections (hero through footer) from `homepage` table |
| 3.2 | About | Bio, qualifications, certifications, safety philosophy, headshot |
| 3.3 | Services listing | Overview page with cards linking to detail pages |
| 3.4 | Service detail | Dynamic route by slug; template: challenge, approach, deliverables, CTA |
| 3.5 | Equipment | Category groupings per BR equipment tree |
| 3.6 | Testimonials / case studies | Listing + optional detail view |
| 3.7 | Blog listing & single post | Categories, publish date, SEO metadata |
| 3.8 | Contact | Form (name, email, phone, message) → DB + email notification |
| 3.9 | Privacy & Terms | CMS-editable legal pages |
| 3.10 | 404 page | Branded error page |

**Frontend components (TDD):** Hero, cards, timeline, accordion, contact form, blog cards, buttons, modals, AOS animations (subtle).

**Exit criteria:** Every public page loads content from DB; contact form stores messages and sends email.

---

### Phase 4 — Admin CMS Modules (Content Management)

**Goal:** Administrator can manage all content without code changes.

| # | Admin Module | Manages |
|---|--------------|---------|
| 4.1 | Homepage Manager | All homepage sections |
| 4.2 | About Manager | About page sections |
| 4.3 | Service Manager | CRUD for 11 services + ordering |
| 4.4 | Equipment Manager | Categories and equipment items |
| 4.5 | Blog Manager | Categories + posts (draft/publish) |
| 4.6 | Testimonials Manager | Case studies and quotes |
| 4.7 | Contact Messages | Inbox, read/unread, export |
| 4.8 | SEO Settings | Per-page and global SEO |
| 4.9 | Website Settings | Contact info, CTAs, legal text |

**Exit criteria:** Full content lifecycle (create → publish → display) works for every module.

---

### Phase 5 — Content Population & SEO

**Goal:** Align live content with Business Requirements.

| # | Task | Source |
|---|------|--------|
| 5.1 | Seed 11 service pages | Business Requirements §2–3, §5.2 sample structure |
| 5.2 | Seed equipment expertise | Business Requirements §4.1 |
| 5.3 | Write homepage copy | Hero, problem/solution, service preview, CTAs |
| 5.4 | Write about page | Bio, qualifications, certifications, safety philosophy |
| 5.5 | Add 2–3 testimonials/case studies | Business Requirements §4.2, Phase 2 launch checklist |
| 5.6 | Publish 3–5 initial blog posts | Business Requirements §8 sample topics |
| 5.7 | On-page SEO | Meta titles/descriptions, heading hierarchy, keyword map (§6.2) |
| 5.8 | Structured data | Organization, LocalBusiness or ProfessionalService schema (optional enhancement) |

**Primary keywords:** radiation equipment installation, medical equipment commissioning, radiotherapy consultancy  
**Secondary:** linac commissioning, CT scanner installation, nuclear medicine equipment services, radiation safety consulting

**Exit criteria:** Site content matches BR sitemap; every service page has complete copy and CTA.

---

### Phase 6 — Performance, Security Hardening & QA

**Goal:** Production-ready quality per SDD/TDD.

| Area | Tasks |
|------|-------|
| **Performance** | Minified Bootstrap/CSS/JS, lazy-loaded images, responsive images, caching headers, compressed assets |
| **Security** | CSRF on all forms, input validation, image validation, role checks, SQL injection/XSS audit |
| **Responsive QA** | Test at 576, 768, 992, 1200+ breakpoints |
| **Cross-browser** | Chrome, Firefox, Safari, Edge |
| **Accessibility** | Alt text on images, form labels, keyboard navigation, contrast |
| **Functional QA** | All CRUD paths, contact workflow, blog publish flow, 404 handling |

**Exit criteria:** Page load acceptable on mobile; security checklist passed; no critical bugs.

---

### Phase 7 — Deployment & Launch

**Goal:** Go live on Hostinger. Launch activities (domain, analytics, announcements) follow Business Requirements §7; deployment steps follow SDD/TDD (PHP application deploy, not WordPress).

| # | Task |
|---|------|
| 7.1 | Register domain (e.g. yournameconsulting.com) |
| 7.2 | Configure Hostinger hosting, SSL, Apache |
| 7.3 | Deploy code; import production database |
| 7.4 | Set production config (DB, mail SMTP for contact notifications) |
| 7.5 | Configure Google Analytics & Google Search Console |
| 7.6 | Submit sitemap |
| 7.7 | Final content proofread |
| 7.8 | Announce launch (LinkedIn, professional networks) |

**Exit criteria:** Live HTTPS site; contact form delivers email; analytics receiving data.

---

### Phase 8 — Ongoing Maintenance (Post-Launch)

Per Business Requirements §7 Phase 5:

- Publish 1–2 blog posts per month  
- Monitor analytics and adjust SEO  
- Update testimonials and case studies  
- Quarterly content refresh  
- Regular backups and security updates  

---

## 9. Key Workflows

### Contact Workflow (SDD)

```
Visitor submits form → Stored in `messages` → Email notification → Visible in admin → Admin replies externally
```

### Blog Workflow (SDD)

```
Admin creates article → Publishes → Visible on public site → SEO metadata stored
```

### Image Workflow (SDD)

```
Admin uploads → Stored in uploads/ → Filename in `media` → Frontend loads dynamically
```

---

## 10. Coding Standards (TDD)

| Element | Convention |
|---------|------------|
| Database | `snake_case` |
| PHP methods | `camelCase` |
| PHP classes | `PascalCase` |
| CSS classes | `kebab-case` |
| DB access | PDO only, prepared statements only — no mysqli |
| Architecture | OOP, MVC-inspired, no duplicated code, reusable components |

---

## 11. Testing Strategy

| Type | Scope |
|------|-------|
| **Unit / integration** | Models, auth, CRUD engine, slug routing |
| **Manual functional** | Every admin module, every public page, contact email |
| **Security** | SQL injection, XSS, CSRF, file upload abuse |
| **Responsive** | All breakpoints on real devices or emulators |
| **Content** | Verify no hardcoded business text remains in views |
| **Deployment smoke test** | Post-deploy checklist on production URL |

---

## 12. Risks & Mitigations

| Risk | Mitigation |
|------|------------|
| Scope creep (11 services + blog + CMS) | Strict phase gates; MVP = Phase 1–4 with seed content in Phase 5 |
| Content not ready at launch | Use BR copy as seed data; consultant reviews in Phase 5 |
| Email delivery on Hostinger | Configure SMTP early; test contact notifications in Phase 3 |
| SEO setup overhead | Sitemap generation, meta management, and Search Console submission handled via built-in SEO module (Phase 2/5) |
| Single admin user | Document password recovery; optional DB reset script |

---

## 13. Suggested Timeline (Indicative)

Assumes one full-stack developer working sequentially:

| Phase | Estimated Duration |
|-------|-------------------|
| Phase 0 — Setup | 1 day |
| Phase 1 — Foundation | 3–5 days |
| Phase 2 — Admin core | 3–4 days |
| Phase 3 — Public pages | 5–7 days |
| Phase 4 — CMS modules | 5–7 days |
| Phase 5 — Content & SEO | 3–5 days (parallel with consultant) |
| Phase 6 — QA & hardening | 2–3 days |
| Phase 7 — Deployment | 1–2 days |
| **Total** | **~4–6 weeks** |

---

## 14. Definition of Done

The project is complete when:

1. All public pages in §5.1 are live and CMS-managed  
2. All 11 service categories from Business Requirements are published with full detail-page structure  
3. Equipment expertise page reflects the three modality groupings  
4. Admin can manage homepage, about, services, equipment, blog, testimonials, SEO, and settings without code  
5. Contact form stores messages and sends email notifications  
6. Site is responsive, SEO-configured, SSL-enabled, and deployed on Hostinger  
7. Initial blog posts and testimonials are published per launch checklist  
8. No business content is hardcoded in HTML templates  

---

## 15. Next Immediate Actions

1. **Phase 0:** Scaffold folder structure and create database migration SQL  
2. **Phase 1:** Implement `db.php`, auth, and both layout shells  
3. **Parallel (consultant):** Provide biography, headshot, certifications list, and 2–3 case study drafts for Phase 5 seeding  

---

*This plan uses `Business_Requirements.pdf` as the source of truth for business content and strategy, and the SDD + TDD in `Project Structure.pdf` as the source of truth for technical stack, architecture, and implementation. WordPress is not part of this project.*
