<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

if (!$resultset) {
    return;
}

?><table class="movieTable">
    <tr class="first">
        <th>Row</th>
        <th>Id</th>
        <th>Picture</th>
        <th>Titel</th>
        <th>Year</th>
    </tr>
<?php $id = -1; foreach ($resultset as $row) :
    $id++; ?>
    <tr>
        <td class="number-cell"><?= $id ?></td>
        <td class="number-cell"><?= $row->id ?></td>
        <td><img class="thumb" src="./../<?= $row->image ?>"></td>
        <td><?= $row->title ?></td>
        <td class="number-cell"><?= $row->year ?></td>
    </tr>
<?php endforeach; ?>
</table>
