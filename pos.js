document.addEventListener("click", e => {
    if(!document.querySelector(".pos-categories").contains(e.target) && !e.target.matches(".editItem_btn")){
            document.querySelector(".pos-categories").style.display = "none";
    }
}}