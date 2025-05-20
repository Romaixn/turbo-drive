import * as Turbo from "@hotwired/turbo"

document.addEventListener("turbo:load", () => {
  if (window.turboDriveOptions && window.turboDriveOptions.progressBarColor) {
    let style = document.getElementById("turbo-progress-style");
    if (!style) {
      style = document.createElement("style");
      style.id = "turbo-progress-style";
      document.head.appendChild(style);
    }

    style.textContent = `.turbo-progress-bar { background-color: ${window.turboDriveOptions.progressBarColor} !important; }`;
  }
});
