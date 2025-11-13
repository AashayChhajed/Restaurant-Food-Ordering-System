<!DOCTYPE html>
<html>
<head>
<title>Kitchen — Live Orders</title>
<style>
    body { background:#fff3e0; padding:20px; font-family:Arial; }
    .order {
        background:white; padding:20px; margin:20px 0;
        border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.1);
    }
    .btn { padding:8px 12px; border:none; color:white; cursor:pointer; }
    .pending { background:#ff9800; }
    .preparing { background:#2196F3; }
    .completed { background:#4CAF50; }
</style>
</head>
<body>

<h1>Kitchen Live Orders</h1>
<div id="orders"></div>

<script>
function load(){
    fetch("live_orders.php")
    .then(r=>r.json())
    .then(data=>{
        let div = document.getElementById("orders");
        div.innerHTML="";

        data.forEach(o=>{
            let html = `<div class="order">
                <h2>Order #${o.id} — ₹${o.total_price}</h2>
                <h3>Status: ${o.status}</h3>
                <ul>`;

            o.items.forEach(i=>{
                html+=`<li>${i.item_name} — ₹${i.price}</li>`;
            });
            html+=`</ul>

                <form method="POST" action="update_status.php">
                    <input type="hidden" name="id" value="${o.id}">
                    <button name="status" value="Pending" class="btn pending">Pending</button>
                    <button name="status" value="Preparing" class="btn preparing">Preparing</button>
                    <button name="status" value="Completed" class="btn completed">Completed</button>
                </form>
            </div>`;

            div.innerHTML += html;
        });
    });
}

setInterval(load, 2000);
load();
</script>

</body>
</html>
