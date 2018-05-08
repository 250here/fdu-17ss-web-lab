const countries = [
    { name: "Canada", continent: "North America", cities: ["Calgary","Montreal","Toronto"], photos: ["canada1.jpg","canada2.jpg","canada3.jpg"] },
    { name: "United States", continent: "North America", cities: ["Boston","Chicago","New York","Seattle","Washington"], photos: ["us1.jpg","us2.jpg"] },
    { name: "Italy", continent: "Europe", cities: ["Florence","Milan","Naples","Rome"], photos: ["italy1.jpg","italy2.jpg","italy3.jpg","italy4.jpg","italy5.jpg","italy6.jpg"] },
    { name: "Spain", continent: "Europe", cities: ["Almeria","Barcelona","Madrid"], photos: ["spain1.jpg","spain2.jpg"] }
];
window.onload=function () {
    let content="";
    for(let i=0;i<countries.length;i++){
        content+="<div class='item'>";
        content+="<h2>"+countries[i].name+"</h2>";
        content+="<p>"+countries[i].continent+"</p>";
        content+="<div class='inner-box'>";
        content+="<h3>Cities</h3>";
        for (let j=0;j<countries[i].cities.length;j++){
            content+="<p>"+countries[i].cities[j]+"</p>";
        }
        content+="</div>";
        content+="<div class='inner-box'>";
        content+="<h3>Popular Photos</h3>";
        for (let j=0;j<countries[i].photos.length;j++){
            content+=`<img src='images/${countries[i].photos[j]}' class='photo'>`;
        }
        content+="</div>";
        content+="<button>Visit</button>";
        content+="</div>";
    }
    let container=document.getElementsByClassName("flex-container justify")[0];
    container.innerHTML=content+"";
}