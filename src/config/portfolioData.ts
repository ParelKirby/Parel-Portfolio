import type { Portfolio, TagColors } from "../types/portfolio";

export const PORTFOLIO_INFO: Portfolio = {
  meta: {
    createdAt: new Date().toISOString(),
    locale: "en-US",
    pdf: "/resume.pdf",
  },
  personal: {
    name: "Chrisalyn Ballera",
    title: "Student / Developer",
    headline: "Student / Developer",
    // avatar can be a string, an object with { url, label }, or an array of those.
    avatar: { url: "./images/ballera.jpg", label: "Chrisalyn Ballera" },
    summary:
      "Quietly becoming stronger, wiser, and better. I may not have it all figured out, but I trust the journey and believe my best chapters are still ahead.",
    hero: {
      summary:
        "Quietly becoming stronger, wiser, and better. I may not have it all figured out, but I trust the journey and believe my best chapters are still ahead.",
    },
    contact: {
      email: "ballerachrisalyn@gmail.com",
      phone: "09396896440",
      location: "Bucay, Abra",
    },
  },
  highlights: [],
  skills: [
    {
      title: "Frontend",
      skills: [
        { name: "HTML/CSS", icon: "SiHtml5" },
        { name: "JavaScript", icon: "SiJavascript" },
        { name: "React", icon: "SiReact" },
        { name: "Tailwind", icon: "SiTailwindcss" },
      ],
    },
    {
      title: "Backend",
      skills: [
        { name: "PHP", icon: "SiPhp" },
        { name: "Laravel", icon: "SiLaravel" },
        { name: "MySQL", icon: "SiMysql" },
      ],
    },
    {
      title: "Tools",
      skills: [
        { name: "Git", icon: "SiGit" },
        { name: "GitHub", icon: "SiGithub" },
        { name: "VS Code", icon: "SiVisualstudiocode" },
      ],
    },
  ],
  experience: [],
  projects: [
    {
      id: "saint-james-elders",
      title: "Online Information and Management System for Saint James Elders",
      short:
        "A centralized web-based capstone project to streamline records management and improve administrative workflows.",
      description:
        "A centralized web-based capstone project designed to streamline records management and improve administrative workflows for Saint James Elders. Developed using Laravel, PHP, MySQL, HTML/CSS, and JavaScript.",
      tags: ["Laravel", "PHP", "MySQL", "HTML/CSS", "JavaScript", "Capstone"],
      isUnderDevelopment: true,
    },
  ],
  education: [
    {
      degree: "Tertiary",
      school: "Data Center College of Bangued",
      date: { start: "2023", present: true },
    },
    {
      degree: "Secondary",
      school: "Our Lady of Fatima School",
      date: { start: "2021", end: "2023" },
    },
  ],
  certifications: [],
  extras: {
    languages: [],
    interests: [],
  },
};

// ---------- SMALL HELPERS ----------
export const tagColors: TagColors = {
  React: "bg-blue-100 text-blue-800",
  CSS: "bg-teal-100 text-teal-800",
  CSS3: "bg-teal-100 text-teal-800",
  Tailwind: "bg-teal-100 text-teal-800",
  Stripe: "bg-purple-100 text-purple-800",
  "Design System": "bg-yellow-100 text-yellow-800",
  D3: "bg-amber-100 text-amber-800",
  Realtime: "bg-green-100 text-green-800",
  Storybook: "bg-pink-100 text-pink-800",
  "NPM Package": "bg-red-100 text-red-800",
  "Material-UI": "bg-indigo-100 text-indigo-800",
  Chatbot: "bg-violet-100 text-violet-800",
  OpenAI: "bg-gray-100 text-gray-800",
  "Hugging Face": "bg-orange-100 text-orange-800",
  Beginner: "bg-cyan-100 text-cyan-800",
  "Beginner Project": "bg-cyan-100 text-cyan-800",
  FastAPI: "bg-teal-500 text-white",
  MongoDB: "bg-green-600 text-white",
  Terraform: "bg-purple-600 text-white",
  IaC: "bg-indigo-500 text-white",
  AWS: "bg-orange-500 text-white",
  Azure: "bg-blue-600 text-white",
  GCP: "bg-red-600 text-white",
  Algorithms: "bg-blue-500 text-blue-100",
  DSA: "bg-purple-300 text-purple-900",
  ML: "bg-blue-200 text-blue-800",
  AI: "bg-gray-200 text-gray-800",
  "AI & ML": "bg-amber-100 text-amber-900",
  Visualization: "bg-orange-100 text-purple-900",
  "Next.js": "bg-black text-white",
  "Full Stack": "bg-gradient-to-r from-blue-500 to-purple-600 text-white",
  Laravel: "bg-red-100 text-red-800",
  PHP: "bg-indigo-100 text-indigo-800",
  MySQL: "bg-blue-100 text-blue-800",
  "HTML/CSS": "bg-orange-100 text-orange-800",
  JavaScript: "bg-yellow-100 text-yellow-800",
  Capstone: "bg-green-100 text-green-800",
};
