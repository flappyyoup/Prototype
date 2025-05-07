// JavaScript to toggle the sidebar
document.addEventListener("DOMContentLoaded", () => {
  const toggleSidebarButton = document.getElementById("toggleSidebar");
  const sidebar = document.getElementById("sidebar");

  if (toggleSidebarButton && sidebar) {
    toggleSidebarButton.addEventListener("click", () => {
      sidebar.classList.toggle("open");
    });
  }
});