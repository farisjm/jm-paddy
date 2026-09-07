<?php
require_once __DIR__ . '/config/config.php'; require_once __DIR__ . '/config/helpers.php'; require_login();
$pageTitle='Dashboard';
$stats=[];
$stats['farmers']=(int)$pdo->query('SELECT COUNT(*) FROM farmers')->fetchColumn();
$stats['bills']=(int)$pdo->query('SELECT COUNT(*) FROM bills')->fetchColumn();
$stats['weight']=(float)$pdo->query('SELECT COALESCE(SUM(gross_weight_kg),0) FROM bills')->fetchColumn();
$stats['amount']=(float)$pdo->query('SELECT COALESCE(SUM(total_amount),0) FROM bills')->fetchColumn();
$recent=$pdo->query('SELECT b.*, f.name farmer_name FROM bills b JOIN farmers f ON f.id=b.farmer_id ORDER BY b.id DESC LIMIT 8')->fetchAll();
include __DIR__.'/includes/header.php';
?>
<div class="cards"><div class="card"><div class="stat-label">Total Farmers</div><div class="stat-value"><?=number_format($stats['farmers'])?></div></div><div class="card"><div class="stat-label">Total Bills</div><div class="stat-value"><?=number_format($stats['bills'])?></div></div><div class="card"><div class="stat-label">Total Weight</div><div class="stat-value"><?=number_format($stats['weight'],2)?> kg</div></div><div class="card"><div class="stat-label">Total Amount</div><div class="stat-value"><?=money($stats['amount'])?></div></div></div>
<div class="section-head"><h2>Recent Bills</h2><a class="btn btn-primary" href="bill_create.php">+ New Bill</a></div>
<div class="table-wrap"><table><thead><tr><th>Bill No.</th><th>Farmer</th><th>Date</th><th>Weight</th><th>Amount</th><th>Status</th><th>Action</th></tr></thead><tbody><?php foreach($recent as $b): ?><tr><td><strong><?=e($b['bill_number'])?></strong></td><td><?=e($b['farmer_name'])?></td><td><?=e(date('d M Y',strtotime($b['bill_date'])))?></td><td><?=number_format((float)$b['gross_weight_kg'],2)?> kg</td><td><?=money($b['total_amount'])?></td><td><span class="badge <?=$b['status']==='Paid'?'badge-paid':'badge-due'?>"><?=e($b['status'])?></span></td><td><a class="btn btn-light" href="bill_view.php?id=<?=$b['id']?>">View</a></td></tr><?php endforeach; ?><?php if(!$recent): ?><tr><td colspan="7" class="empty">No bills yet.</td></tr><?php endif; ?></tbody></table></div>
<?php include __DIR__.'/includes/footer.php'; ?>
