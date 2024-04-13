var hold_num = -1;
let cartArray = JSON.parse(sessionStorage.getItem('cartArray')) || [];
refreshCartDiv();

function addToCartByArray(id, name, price, qty) {
    const existingItem = cartArray.find(item => item[0] === id);

    if (existingItem) {
        existingItem[3] = existingItem[3] + qty;
    } else {
        cartArray.push([id, name, price, qty]);
    }

    sessionStorage.setItem('cartArray', JSON.stringify(cartArray));
    refreshCartDiv();
}

function displayAllArray(){
    cartArray.forEach(element => {
        console.log(element);
    });
   
}

function refreshCartDiv(){
    document.querySelector(".pos-cart-list-ul").innerHTML = "";


    cartArray.forEach(element => {
        createListItem(element[1],element[2] * element[3],element[3]);
    });
}

function createListItem(prodName, prodPrice, prodQty) {
    // Create the list item element
    const listItem = document.createElement('li');
  
    // Create the figure element
    const figure = document.createElement('figure');
    listItem.appendChild(figure);
  
    // Create the span element and add the name and quantity
    const span = document.createElement('span');
    const h3 = document.createElement('h3');
    h3.textContent = prodName;
    const small = document.createElement('small');
    small.textContent = `Quantity: ${prodQty}`;
    span.appendChild(h3);
    span.appendChild(small);
    listItem.appendChild(span);
  
    // Add the price
    const priceElement = document.createElement('b');
    priceElement.textContent = `₱ ${prodPrice}`;
    listItem.appendChild(priceElement);
  
    // Create the delete button
    const deleteButton = document.createElement('button');
    deleteButton.type = 'submit';
    deleteButton.name = 'deleteItem';
    deleteButton.innerHTML = `
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" id="delete">
        <path fill="#000" d="M15 3a1 1 0 0 1 1 1h2a1 1 0 1 1 0 2H6a1 1 0 0 1 0-2h2a1 1 0 0 1 1-1h6Z"></path>
        <path fill="#000" fill-rule="evenodd" d="M6 7h12v12a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V7Zm3.5 2a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 1 0v-9a.5.5 0 0 0-.5-.5Zm5 0a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 1 0v-9a.5.5 0 0 0-.5-.5Z" clip-rule="evenodd"></path>
      </svg>
    `;

    deleteButton.addEventListener('click', function(event) {
        const index = cartArray.findIndex(item => item[1] === prodName && item[2] * item[3] === prodPrice && item[3] === prodQty);
    	    if (index !== -1) {
        	cartArray.splice(index, 1);
        	sessionStorage.setItem('cartArray', JSON.stringify(cartArray));
        	refreshCartDiv();
    	    }
    });

    listItem.appendChild(deleteButton);
  
    // Return the list item element
    document.querySelector(".pos-cart-list-ul").appendChild(listItem);
    return listItem;
  }

function hold(event) {
        let button = event.target.closest('.addToCart_btn');
        let btn_id = button.value;
        let btn_name = button.querySelector('figure h3').innerHTML;
        let btn_price = parseInt(button.querySelector('.pos-product-price').textContent.match(/\d+/)[0],10);
        addToCartByArray(btn_id,btn_name,btn_price,1);
        console.log(btn_price);
        if(hold_num == -1){
            hold_num = setInterval(() => onHold(button), 1000);
        }
       
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
        addToCartByArray(button.value,0,0, quantity-1);
    }
    displayAllArray();
    
}

var buttons = document.querySelectorAll('.addToCart_btn');
    buttons.forEach((button) => {
        button.addEventListener("mousedown", hold);
        button.addEventListener("mouseup", release);
        button.addEventListener("mouseout", release);
    });

document.getElementById("clr-cart-btn").addEventListener("click", e=>{
    cartArray.splice (0,cartArray.length);
    sessionStorage.setItem('cartArray', JSON.stringify(cartArray));
    refreshCartDiv();
})