(function () {
  function getStorageKey(id) {
    return 'PageBanner_' + id + '_Dismiss';
  }

  // Called when a user closes a banner.
  function callback(event) {
      const button = event.currentTarget;
      const bannerId = button.getAttribute('data-id');
      const banner = document.getElementById('page-banner-' + bannerId);

      // The banner can only be closed once, so we don't need the click handler anymore.
    button.removeEventListener('click', callback);

    // Remove the banner from the page.
    banner.parentNode.removeChild(banner);

    // Make sure the banner doesn't re-appear when the page is re-loaded.
    sessionStorage.setItem(getStorageKey(bannerId), 'true');
  }

    const bannersNodeList = document.querySelectorAll('.page-banner');
    let index = 0;
    let bannerId = 0;
    let button = null;


    for (index; index < bannersNodeList.length; index += 1) {
    bannerId = bannersNodeList[index].getAttribute('data-id');

    // Don't display banners which have been dismissed.
    if (sessionStorage.getItem(getStorageKey(bannerId))) {
      continue;
    }

    // Display the banner.
    bannersNodeList[index].setAttribute('aria-hidden', 'false');

    // Add a click event the "dismiss" button, if it exists.
    button = document.querySelector('#' + bannersNodeList[index].id + ' .page-banner-close');

    if (button) {
      // hide close button for browsers without sessionStorage compatibility
      if (!sessionStorage) {
        button.style.display = 'none';
      } else {
        button.addEventListener('click', callback);
      }
    }
  }
}());
