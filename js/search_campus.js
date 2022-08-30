const search_campus = document.querySelector('#search_campus');
if (search_campus) {
  search_campus.addEventListener('click', (e) => {
    e.preventDefault();
    let address = document.querySelector('#address').value;
    address.replaceAll(' ', '+').trim();
    document.querySelector('#campus_map').innerHTML = `
    <div class="ratio ratio-16x9">
      <iframe src="https://maps.google.com/maps?q=${address}&output=embed" title="campus map" allow="geolocation"></iframe>
    </div>`;
  });
}
