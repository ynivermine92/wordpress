/* coomment */

document.querySelectorAll('.dco-attachment-gallery').forEach((gallery, index) => {

  const group = 'comments-' + index;

  gallery.querySelectorAll('.dco-image-attachment-link').forEach(link => {
    link.setAttribute('data-fancybox', group);
  });

});

/* coomment fancybox */
Fancybox.bind('[data-fancybox^="comments-"]', {
  Carousel: {
    Thumbs: {
      type: "classic",
    },
  },
  Zoomable: {
    Panzoom: {
      clickAction: "iterateZoom",
      maxScale: 2,
    },
  },
});
