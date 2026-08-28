import React from "react";
import { motion } from "framer-motion";
import { IoSchoolOutline } from "react-icons/io5";
import type { DateRange, Education as EducationType } from "../types/portfolio";

function formatDate(date?: DateRange | string): string {
  if (!date) return "";
  if (typeof date === "string") return date;
  const { start, end, present } = date;
  if (present) return `${start ?? ""} — Present`;
  return [start, end].filter(Boolean).join(" — ");
}

export const Education: React.FC<{ education?: EducationType[] }> = ({
  education = [],
}) => {
  if (!education.length) return null;

  return (
    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
      {education.map((ed, idx) => (
        <motion.div
          key={ed.school ?? idx}
          initial={{ opacity: 0, y: 12 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true, margin: "-80px" }}
          transition={{ duration: 0.4, delay: idx * 0.08 }}
          className="p-6 rounded-2xl bg-[var(--surface)] border border-[var(--border)] flex gap-4 items-start"
        >
          <div className="shrink-0 w-12 h-12 rounded-xl bg-[var(--brand)]/10 flex items-center justify-center text-[var(--brand)]">
            <IoSchoolOutline size={26} />
          </div>
          <div className="min-w-0">
            {ed.degree && (
              <div className="text-xs font-semibold uppercase tracking-wide text-[var(--brand)]">
                {ed.degree}
              </div>
            )}
            <div className="mt-1 font-medium text-[var(--text)]">
              {ed.school}
            </div>
            <div className="mt-1 text-sm text-gray-500 dark:text-gray-400">
              {formatDate(ed.date)}
            </div>
          </div>
        </motion.div>
      ))}
    </div>
  );
};

export default Education;
