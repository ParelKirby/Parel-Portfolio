// PortfolioPage.tsx
import React, { useState } from "react";
import { AnimatePresence, motion } from "framer-motion";
import { ThemeProvider } from "../components/ThemeProvider";
import { Header } from "../components/shared/Header";
import { ProjectsGrid } from "../components/ProjectsGrid";
import { SkillsList } from "../components/SkillsList";
import { Education } from "../components/Education";
import { Footer } from "../components/shared/Footer";
import { PORTFOLIO_INFO } from "../config/portfolioData";
import { About } from "../components/About";
import { AppleHelloEnglishEffect } from "../components/HelloEffects";
import type { Project } from "../types/portfolio";
import { ProjectModal } from "../components/ProjectModal";
import { ScrollProgressBar } from "../components/shared/ScrollProgressBar";
import { ScrollToTop } from "../components/shared/ScrollToTop";

const PortfolioPage: React.FC = () => {
  const [selected, setSelected] = useState<Project | null>(null);
  const [showHello, setShowHello] = useState(true);

  return (
    <ThemeProvider>
      <ScrollProgressBar />
      <Header
        links={[
          { href: "#about", label: "About" },
          { href: "#projects", label: "Projects" },
          { href: "#skills", label: "Skills" },
          { href: "#education", label: "Education" },
          { href: "#contact", label: "Contact" },
        ]}
      />

      {/* About / hero: hidden while hello animation plays */}
      <AnimatePresence>
        {showHello && (
          <motion.div
            key="hello-overlay"
            className="fixed inset-0 z-50 flex items-center justify-center bg-black/90"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
          >
            <AppleHelloEnglishEffect
              className="text-white"
              onAnimationComplete={() => setShowHello(false)}
            />
          </motion.div>
        )}
      </AnimatePresence>

      <motion.section
        id="about"
        className="hero-panel relative h-screen min-h-screen w-full overflow-hidden"
        initial={{ opacity: 0, y: 8 }}
        animate={showHello ? { opacity: 0, y: 8 } : { opacity: 1, y: 0 }}
        transition={{ duration: 0.6, ease: "easeOut" }}
      >
        <div className="relative z-10 flex min-h-screen w-full items-center justify-center px-4 sm:px-6 lg:px-8">
          <div className="w-full max-w-6xl 2xl:max-w-7xl mx-auto">
            <About />
          </div>
        </div>
      </motion.section>

      <main className="max-w-6xl 2xl:max-w-9xl mx-auto px-6 py-15 sm:py-20 lg:py-32 relative z-20">
        <section id="projects" className="py-8">
          <h2 className="text-2xl font-semibold text-[var(--brand)]">Projects</h2>
          <p className="mb-6 text-sm text-gray-500 dark:text-gray-400 mt-1">
            Selected work — click a card for details.
          </p>
          <ProjectsGrid
            projects={PORTFOLIO_INFO.projects}
            onOpen={setSelected}
          />
        </section>

        <section id="skills" className="py-8">
          <h2 className="text-2xl font-semibold text-[var(--brand)]">Skills</h2>
          <p className="mb-6 text-sm text-gray-500 dark:text-gray-400 mt-1">
            Tools and technologies I use regularly.
          </p>
          <SkillsList skills={PORTFOLIO_INFO.skills} isBar={true} />
        </section>

        <section id="education" className="py-8">
          <h2 className="text-2xl font-semibold text-[var(--brand)]">
            Educational Background
          </h2>
          <p className="mb-6 mt-1 text-sm text-gray-500 dark:text-gray-400">
            My academic journey.
          </p>
          <Education education={PORTFOLIO_INFO.education} />
        </section>

        <section id="contact" className="py-8">
          <h2 className="text-2xl font-semibold text-[var(--brand)]">Contact</h2>
          <p className="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Tell me about your project, or just say hi.
          </p>
          <div className="mt-6">
            <div className="p-6 rounded-2xl bg-[var(--surface)] border border-[var(--border)] flex flex-col gap-4">
              <div>
                <div className="font-semibold">Let's collaborate</div>
                <div className="text-sm text-gray-500 dark:text-gray-400">
                  I'm available for freelance and contract work. My inbox is
                  open.
                </div>
              </div>
              <div className="mt-2">
                <div className="font-semibold">Quick contact</div>
                <div className="mt-2 text-sm text-gray-500 dark:text-gray-400">
                  Email: ballerachrisalyn@gmail.com
                </div>
                <div className="text-sm text-gray-500 dark:text-gray-400">
                  Phone: 09396896440
                </div>
                <div className="text-sm text-gray-500 dark:text-gray-400">
                  Location: Bucay, Abra
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>
      <ScrollToTop />
      <Footer />

      <ProjectModal
        project={selected}
        open={!!selected}
        onClose={() => setSelected(null)}
      />
    </ThemeProvider>
  );
};

export default PortfolioPage;
