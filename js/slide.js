function slide(id, data, tag) {
    let slide = $(id).find('.carousel-inner');
    slide.html('');

    let x = 0;
    for (let i = 0; i < data.length; i++) {
        let item = data[i];

		console.log('tag:'+tag);

        // FILTRA SOLO LOS DEL TAG SELECCIONADO
        if (tag != '' && item.tag != tag)
            continue;

        x++;
        let htmlMedia = '';
        if (item.media_tipo == 'jpg') {
            htmlMedia = `<img class="d-block w-100" src="${item.media_url}">`;
        } else if (item.media_tipo == 'mp4') {
            htmlMedia = `
                <video class='video-fluid' style='width: 100%;' autoplay loop muted>
                    <source src='${item.media_url}' type='video/mp4'>
                </video>
                `;
        }

        slide.append(`
			<a href="${item.url}" class="carousel-item ${x == 1 ? 'active' : ''}">
                ${htmlMedia}
                <div class="carousel-caption">
                    <p>${item.texto}</p>
                </div>
			</a>
        `);
    }
}
