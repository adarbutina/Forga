export default function (el) {
  const isDesktopMediaQuery = window.matchMedia('(min-width: 1024px)');
  isDesktopMediaQuery.addEventListener('change', onBreakpointChange);

  onBreakpointChange();

  function onBreakpointChange() {
    if (isDesktopMediaQuery.matches) {
      setScrollPaddingTop();
    }
  }

  function setScrollPaddingTop() {
    const paddingTop = document.getElementById('wpadminbar') ? document.getElementById('wpadminbar').offsetHeight : 0;
    document.documentElement.style.scrollPaddingTop = `${paddingTop}px`;
  }
}
