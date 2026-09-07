<?php
require_once __DIR__ . '/config/config.php'; require_once __DIR__ . '/config/helpers.php'; require_login();
$pageTitle='Farmers'; $q=trim($_GET['q']??'');
$sql='SELECT f.*, COUNT(b.id) bill_count, COALESCE(SUM(b.total_amount),0) total_purchases FROM farmers f LEFT JOIN bills b ON b.farmer_id=f.id'; $params=[];
if($q!==''){ $sql.=' WHERE f.name LIKE ? OR f.phone LIKE ?'; $params=["%$q%","%$q%"]; } $sql.=' GROUP BY f.id ORDER BY f.id DESC';
$stmt=$pdo->prepare($sql); $stmt->execute($params); $farmers=$stmt->fetchAll();
include __DIR__.'/includes/header.php';
?>
<div class="section-head"><div class="toolbar"><form class="search" method="get"><input class="field" style="border:1px solid #d7ddd8;border-radius:7px;padding:11px" name="q" value="<?=e($q)?>" placeholder="Search by name or phone number"><button class="btn btn-light">Search</button></form></div><a class="btn btn-primary" href="farmer_edit.php">+ Add Farmer</a></div>
<div class="table-wrap"><table><thead><tr><th>Farmer</th><th>Phone</th><th>District</th><th>Total Purchases</th><th>Bills</th><th>Action</th></tr></thead><tbody><?php foreach($farmers as $f): ?><tr><td><strong><?=e($f['name'])?></strong></td><td><?=e($f['phone'])?></td><td><?=e($f['district'])?></td><td><?=money($f['total_purchases'])?></td><td><?=number_format($f['bill_count'])?></td><td><div class="actions"><a class="btn btn-light" href="farmer_edit.php?id=<?=$f['id']?>">Edit</a><a class="btn btn-secondary" href="farmer_view.php?id=<?=$f['id']?>">View</a></div></td></tr><?php endforeach; ?><?php if(!$farmers): ?><tr><td colspan="6" class="empty">No farmers found.</td></tr><?php endif; ?></tbody></table></div>
<?php include __DIR__.'/includes/footer.php'; ?>
