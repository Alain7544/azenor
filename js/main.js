window.addEventListener('load', () => {
  if (!overlay) return;

  // Only on first visit in this browser
    overlay.remove();
    return;
  }

  const displayTime = 4500;
  setTimeout(() => overlay.remove(), displayTime + 2600);
});
