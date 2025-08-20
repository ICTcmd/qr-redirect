<script src="redirects.js"></script>
<script>
  const slug = window.location.pathname.split('/').pop();
  const target = redirects[slug];
  if (target) window.location.href = target;
  else document.body.innerHTML = `<h2>🚫 File not found</h2><p>No redirect available for <code>${slug}</code>.</p>`;
</script>
