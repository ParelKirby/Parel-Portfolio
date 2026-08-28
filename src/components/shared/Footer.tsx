import React from "react";

export const Footer: React.FC = () => {
  return (
    <footer className="text-sm text-[var(--muted)] border-t border-[var(--border)] py-6">
      <div className="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4 px-6">
        <div>
          Designed &amp; coded with ☕ + ❤️ by{" "}
          <span className="font-medium text-[var(--text)]">
            Chrisalyn Ballera
          </span>
        </div>
      </div>
    </footer>
  );
};
