# Chrisalyn Ballera — Portfolio

A modern, responsive developer portfolio website built with **React 19, TypeScript, and Tailwind CSS 4**. Showcases my personal brand, skills, projects, education, and contact details.

🔗 **Live Demo**: [https://satya00089.github.io/portfolio](https://satya00089.github.io/portfolio)

> Modern developer portfolio featuring:
> - Interactive portfolio with project modals
> - Dynamic resume with print + CLI-style terminal resume
> - Dark/light theme
> - Data-driven content

## ℹ️ System Overview

This is a single-page React application (originally forked from the open-source `satya00089/portfolio` template and personalized) with two routes:

- **Portfolio page** (`/`) — hero/About, Projects, Skills, Education, and Contact sections, plus a "Hello" intro animation.
- **Resume page** (`/resume`) — printable, interactive resume with a CLI-style terminal view.

All site content is **data-driven** from one configuration file, `src/config/portfolioData.ts`, so updating your info never requires touching component code.

## ✨ Key Features

- **Interactive Portfolio** — project cards with modal detail views and GitHub-flavored markdown descriptions
- **Dynamic Resume** — resume page with print functionality
- **CLI Resume** — terminal-style resume for a unique experience
- **Skills Visualization** — circular progress bars and animated skill lists
- **Theme Support** — dark/light toggle via React context
- **Smooth Animations** — Framer Motion transitions throughout
- **"Hello" Intro** — an Apple-style hello animation on load
- **Contact Section** — quick contact info and freelance call-to-action
- **Responsive Design** — fully responsive across all device sizes
- **Scroll Enhancements** — progress bar and scroll-to-top

## 🛠️ Tech Stack

### Core
- **React 19** — UI framework
- **TypeScript** — type safety
- **Vite 7** — build tool & dev server
- **React Router DOM** — client-side routing (hash-based for GitHub Pages)

### Styling
- **Tailwind CSS 4** — utility-first styling (via `@tailwindcss/vite`)
- **Framer Motion** — animations
- **Lucide React** / **React Icons** — icon libraries

### Additional Libraries
- **React Markdown** + **remark-gfm** — markdown rendering
- **React Circular Progressbar** — skill visualization
- **React Scroll** — smooth scrolling
- **GitHub Markdown CSS** — markdown styling

## 👤 About Me

- **Name**: Chrisalyn Ballera
- **Title**: Student / Developer
- **Location**: Bucay, Abra
- **Email**: ballerachrisalyn@gmail.com
- **Phone**: 09396896440

**Summary**: "Quietly becoming stronger, wiser, and better. I may not have it all figured out, but I trust the journey and believe my best chapters are still ahead."

### Skills
| Category | Skills |
|----------|--------|
| **Frontend** | HTML/CSS, JavaScript, React, Tailwind |
| **Backend** | PHP, Laravel, MySQL |
| **Tools** | Git, GitHub, VS Code |

### Featured Project
- **Online Information and Management System for Saint James Elders** — a centralized web-based capstone project (Laravel, PHP, MySQL, HTML/CSS, JavaScript) to streamline records management, currently under development.

### Education
- **Tertiary** — Data Center College of Bangued (2023–present)
- **Secondary** — Our Lady of Fatima School (2021–2023)

## 📁 Project Structure

```
src/
├── components/          # Reusable UI components
│   ├── shared/         # Shared components (Header, Footer, ProgressBar, etc.)
│   ├── resume/         # Resume-specific components
│   ├── hooks/          # Custom React hooks
│   └── ...             # Section components (About, Projects, Skills, Education)
├── pages/              # Page components
│   ├── PortfolioPage.tsx
│   └── ResumePage.tsx
├── config/             # Site content
│   └── portfolioData.ts    <-- edit this to customize
├── context/            # React contexts (Theme)
├── types/              # TypeScript type definitions
├── lib/                # Utility library
└── assets/             # Static assets
```

## 🚀 Getting Started

### Prerequisites
- Node.js v18+
- npm or yarn

### Installation

```bash
npm install
npm run dev
```

Open [http://localhost:5173](http://localhost:5173).

## 📝 Available Scripts

| Script | Description |
|--------|-------------|
| `npm run dev` | Start development server |
| `npm run build` | Type-check + build for production |
| `npm run preview` | Preview production build locally |
| `npm run lint` | Run ESLint |
| `npm run deploy` | Deploy to GitHub Pages |
| `npm run format` | Format code with Prettier |

## 🎨 Customization

All personal data lives in **`src/config/portfolioData.ts`** — edit `personal`, `skills`, `projects`, `education`, and `experience` to customize the site.

Theme logic is in `src/context/ThemeProvider.tsx`. Tailwind is configured via `tailwind.config.js` (v4 plugin setup in `vite.config.ts`).

## 🌐 Deployment

Configured for GitHub Pages with `base: "/portfolio/"` in `vite.config.ts`:

```bash
npm run build
npm run deploy
```

Update the `homepage` field in `package.json` and the `base` in `vite.config.ts` for a different URL.

## 📄 License

Open source under the [MIT License](LICENSE.md).
