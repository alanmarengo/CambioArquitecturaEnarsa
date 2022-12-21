const get_data_galery = (presa, container_id) =>{
    $.get({
		async:true,
        url:`./carrusel_represas.php?represa=${presa}`,
        success:function(d){
            print_galery(container_id, JSON.parse(d))
        }        
    });	   
}


const print_galery = (container_id, data) => {
    const  container = document.getElementById(container_id)
    let html = '';
    let html_img = '';
    if(data.length > 0){

    data.map((img, index) => {
        html_img +=`
            <div class="img_container">
                <img src="${img.recurso_path_url}" onclick='open_image_galery("${img.recurso_path_url}")'/>
            </div>
        `
    })

    html += `
        <div class="galery_images" style="background-color: white;" >
            <div class="displace_container" id="left" onclick="displace_galery('${container_id}_galery','left')">
                <div class="iconContainer">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7.633 13.351">
                        <path id="Icon_ionic-ios-arrow-back" data-name="Icon ionic-ios-arrow-back" d="M2.3,6.674,7.352,1.626A.954.954,0,0,0,6,.279L.278,6A.952.952,0,0,0,.25,7.313L6,13.072a.954.954,0,0,0,1.351-1.347Z" />
                    </svg>
                </div>
                </div>
                <div class="galery_container" id="${container_id}_galery">
                    ${html_img}
                </div>
                <div class="displace_container">
                <div class="iconContainer" id="right" onclick="displace_galery('${container_id}_galery','right')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7.633 13.351">
                        <path id="Icon_ionic-ios-arrow-back" data-name="Icon ionic-ios-arrow-back" d="M2.3,6.674,7.352,1.626A.954.954,0,0,0,6,.279L.278,6A.952.952,0,0,0,.25,7.313L6,13.072a.954.954,0,0,0,1.351-1.347Z" />
                    </svg>
                </div>
            </div>
        </div>
    `
    }   



    container.innerHTML = html

}

const displace_galery = (container_galery, direction_displace) => {
    const container = document.getElementById(container_galery)
    if(direction_displace === "right"){
        container.scrollLeft += 350;
    }else if(direction_displace === "left"){
        container.scrollLeft -= 350;
    } 
} 

const open_image_galery = (img) => {
    const container = document.getElementById('img_open')
    console.log(img)
    let html = 
    `   
    <div class="conatiner_img_galery">
        <div class="background_close" onclick="close_image_galery()"> 
            <div class="x_icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24.241 24.241">
                <line id="Línea_45" data-name="Línea 45" x1="20" y2="19" transform="translate(2.121 2.621)" fill="none" stroke-linecap="round" stroke-width="3"/>
                <line id="Línea_46" data-name="Línea 46" x1="20" y2="19" transform="translate(21.621 2.121) rotate(90)" stroke-linecap="round" stroke-width="3"/>
                </svg>
            </div>
            <div class="content_img_expand">
                <img src="${img}" /> 
            </div>
       </div>

    </div>    
    `

    container.innerHTML = html
}
const close_image_galery = () => {
    const container = document.getElementById('img_open')
    container.innerHTML = null
}