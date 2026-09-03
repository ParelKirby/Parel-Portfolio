import "./bootstrap";

import { onReady, $ } from "./utils";

import "./theme";
import "./header";
import "./scroll-progress";
import "./scroll-to-top";
import "./reveal";
import "./hero";
import "./projects";
import "./skills";
import "./cli";

onReady(() => {
    const printBtn = $("#print-resume");
    if (printBtn) printBtn.addEventListener("click", () => window.print());
});
