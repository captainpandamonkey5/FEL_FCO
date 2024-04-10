var hold_num = -1;  
let cartArray = []

function addToCartByArray(id, qty) {
    const existingItem = JSON.parse(localStorage.getItem('cartArray')).find(item => item[0] === id);

    if (existingItem) {
        existingItem[1] = existingItem[1]+qty;
        sessionStorage.setItem('cartArray', JSON.stringify(cartArray));
    } else {
        cartArray.push([id, qty]);
        sessionStorage.setItem('cartArray', JSON.stringify(cartArray));
    }
}

function displayAllArray(){
    cartArray.forEach(element => {
        console.log(element);
    });
   
}

function hold(event) {
        let button = event.target.closest('.addToCart_btn');
        addToCartByArray(button.value,1)
        if(hold_num == -1){
            hold_num = setInterval(() => onHold(button), 1000);
        }
        displayAllArray();
    }
    
function release(event) {
    if(hold_num != -1) {  
        clearInterval(hold_num);
        hold_num = -1;
    }

}

function onHold(button) {
    release();
    let quantity = prompt("Enter quantity:");
    if(quantity!=null && quantity!=""){
        addToCartByArray(button.value, quantity-1);
    }
    displayAllArray();
    
}

var buttons = document.querySelectorAll('.addToCart_btn');
    buttons.forEach((button) => {
        button.addEventListener("mousedown", hold);
        button.addEventListener("mouseup", release);
        button.addEventListener("mouseout", release);
    });