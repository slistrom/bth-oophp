<?php
if (!$resultset) {
    return;
}
?>
<script src="https://use.fontawesome.com/e5579368c4.js"></script>
<table class="cmsTable">
    <tr class="first">
        <th>Actions</th>
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Published</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Deleted</th>
    </tr>
<?php $id = -1; foreach ($resultset as $row) :
    $id++; ?>
    <tr>
        <td>
            <a class="icons" href="edit?id=<?= $row->id ?>" title="Edit this content">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            </a>
            <a class="icons" href="delete?id=<?= $row->id ?>" title="Edit this content">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
            </a>
        </td>
        <td><?= $row->id ?></td>
        <td><?= $row->title ?></td>
        <td><?= $row->type ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->created ?></td>
        <td><?= $row->updated ?></td>
        <td><?= $row->deleted ?></td>
    </tr>
<?php endforeach; ?>
</table>
