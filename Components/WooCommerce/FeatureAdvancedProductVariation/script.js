export default function () {
  jQuery(document.body).on('found_variation', setPermalink);

  function setPermalink(event, variation) {
    const url = new URL(window.location.href);
    const params = url.searchParams;

    Object.entries(variation.attributes).forEach(([key, value]) => {
      if (value) {
        params.set(key, value);
      } else {
        params.delete(key);
      }
    });

    window.history.replaceState({}, '', url.toString());
  }

  return () => {
    jQuery(document.body).off('found_variation', setPermalink);
  }
}
