<!DOCTYPE html>
<html>
<head>
<title>La Burgir — Order Food</title>
<style>
    body { font-family: Arial; margin: 0; background: #f4fff4; }
    .sidebar {
        width: 220px; height: 100vh; background: #2e7d32;
        padding: 20px; position: fixed; color: white;
    }
    .sidebar h2 { text-align: center; }
    .sidebar a {
        color: white; text-decoration: none; display: block; margin: 15px 0;
        font-size: 18px;
    }
    .main { margin-left: 260px; padding: 20px; }
    .grid { display: grid; grid-template-columns: repeat(3,1fr); gap:20px; }
    .card { background:white; padding:15px; border-radius:10px;
        box-shadow:0 2px 6px rgba(0,0,0,0.1); text-align:center; }
    .card img { width:100%; height:180px; object-fit:cover; border-radius:10px; }
    .btn { padding:8px 12px; background:#43a047; color:white; border:none; cursor:pointer; margin-top:10px; }
    .btn:hover { background:#388e3c; }
</style>
</head>
<body>

<div class="sidebar">
    <h2>La Burgir</h2>
    <a href="#" onclick="show('pizza')">Pizza</a>
    <a href="#" onclick="show('burger')">Burger</a>
    <a href="#" onclick="show('drinks')">Drinks</a>
    <a href="#" onclick="show('desserts')">Desserts</a>
    <a href="#" onclick="show('cart')">Cart</a>
</div>

<div class="main">

    <!-- Categories -->
    <div id="pizza" class="cat">
        <h1>Pizza</h1>
        <div class="grid">
            <div class="card">
                <img src="images/margherita.jpg">
                <p>Classic Margherita — ₹200</p>
                <button class="btn" onclick="add('Classic Margherita',200)">Add</button>
            </div>
            <div class="card">
                <img src="images/double_cheese.jpg">
                <p>Double Cheese — ₹345</p>
                <button class="btn" onclick="add('Double Cheese',345)">Add</button>
            </div>
        </div>
    </div>

    <div id="burger" class="cat" style="display:none">
        <h1>Burger</h1>
        <div class="grid">
            <div class="card">
                <img src="images/cheese_burger.jpg">
                <p>Cheese Burger — ₹150</p>
                <button class="btn" onclick="add('Cheese Burger',150)">Add</button>
            </div>
        </div>
    </div>

    <div id="drinks" class="cat" style="display:none">
        <h1>Drinks</h1>
        <div class="grid">
            <div class="card"><img src="images/coke.jpg"><p>Coke — ₹50</p><button class="btn" onclick="add('Coke',50)">Add</button></div>
        </div>
    </div>

    <div id="desserts" class="cat" style="display:none">
        <h1>Desserts</h1>
        <div class="grid">
            <div class="card"><img src="images/brownie.jpg"><p>Brownie — ₹150</p><button class="btn" onclick="add('Brownie',150)">Add</button></div>
        </div>
    </div>

    <!-- CART -->
    <div id="cart" class="cat" style="display:none">
        <h1>Your Cart</h1>
        <ul id="cartList"></ul>
        <h2>Total: ₹<span id="total">0</span></h2>
        <button class="btn" style="background:#ff5722" onclick="checkout()">Place Order</button>
    </div>

</div>

<script>
let cart = [];

function show(cat) {
    document.querySelectorAll('.cat').forEach(c => c.style.display='none');
    document.getElementById(cat).style.display='block';
}

function add(name, price) {
    cart.push({name, price});
    alert(name + " added to cart.");
}

function updateUI() {
    let list = document.getElementById('cartList');
    list.innerHTML = "";

    let total = 0;
    cart.forEach(i => {
        list.innerHTML += `<li>${i.name} — ₹${i.price}</li>`;
        total += i.price;
    });

    document.getElementById("total").innerText = total;
}
setInterval(updateUI, 500);

function checkout() {
    if (cart.length === 0) return alert("Cart empty!");

    fetch("submit_order.php", {
        method:"POST",
        headers:{"Content-Type":"application/json"},
        body:JSON.stringify({items: cart})
    })
    .then(r=>r.json())
    .then(d=>{
        if(d.success){
            alert("Order placed!");
            cart = [];
            updateUI();
            show('pizza');
        }
    })
}
</script>

</body>
</html>
