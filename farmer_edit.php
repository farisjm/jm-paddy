<?php
require_once __DIR__ . '/config/config.php'; require_once __DIR__ . '/config/helpers.php'; require_login();
$id=(int)($_GET['id']??0); $editing=$id>0; $farmer=['name'=>'','phone'=>'','address'=>'','district'=>'Vavuniya'];
if($editing){$s=$pdo->prepare('SELECT * FROM farmers WHERE id=?');$s->execute([$id]);$farmer=$s->fetch() ?: redirect('farmers.php');}
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf($_POST['csrf']??null);
 $data=[trim($_POST['name']??''),trim($_POST['phone']??''),trim($_POST['address']??''),trim($_POST['district']??'Vavuniya')];
 if($data[0]===''){flash('error','Farmer name is required.');redirect($editing?'farmer_edit.php?id='.$id:'farmer_edit.php');}
 if($editing){$s=$pdo->prepare('UPDATE farmers SET name=?,phone=?,address=?,district=? WHERE id=?');$s->execute([...$data,$id]);flash('success','Farmer updated successfully.');}else{$s=$pdo->prepare('INSERT INTO farmers(name,phone,address,district) VALUES(?,?,?,?)');$s->execute($data);flash('success','Farmer added successfully.');} redirect('farmers.php');
}
$pageTitle=$editing?'Edit Farmer':'Add Farmer';$districts=districts($pdo);include __DIR__.'/includes/header.php';
?>
<div class="form-section"><form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><div class="form-grid"><div class="field"><label>Farmer Name</label><input name="name" value="<?=e($farmer['name'])?>" required></div><div class="field"><label>Phone Number</label><input name="phone" value="<?=e($farmer['phone'])?>" placeholder="07X XXX XXXX"></div><div class="field"><label>District</label><select name="district"><?php foreach($districts as $d): ?><option <?=($farmer['district']===$d['district']?'selected':'')?>><?=e($d['district'])?></option><?php endforeach;?></select></div><div class="field" style="grid-column:1/-1"><label>Address</label><textarea name="address"><?=e($farmer['address'])?></textarea></div></div><div class="actions mt"><button class="btn btn-primary" type="submit">Save Farmer</button><a class="btn btn-light" href="farmers.php">Cancel</a></div></form></div>
<?php include __DIR__.'/includes/footer.php'; ?>
