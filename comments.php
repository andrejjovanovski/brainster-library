<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] != 1) {
    header('Location: index.php');
    die();
}
require_once "./partials/header.php";
require_once "./Comments/Comment.php";
use Comments\Comment as Comment;

$comment = new Comment();
$allCommentsPendingApproval = $comment->getAllCommentsPendingApproval();
$allDeclinedComments = $comment->getAllDeclinedComments();

require_once "./partials/navbar.php";
?>

<div class="flex-grow px-3">
    <div class="w-full mt-12">
        <!--                DECLINED COMMENTS TABLE-->
        <div class="flex flex-wrap mt-6">
            <div class="w-full lg:w-1/2 pr-0 lg:pr-2 mt-10">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <h2 class="mb-3 font-bold text-xl">Declined Comments</h2>
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-900 uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Client id
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Comment
                            </th>
                            <th scope="col" class="px-6 py-3">
                                book id
                            </th>
                            <th scope="col" class="px-6 py-3">
                                created at
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Approve
                            </th>
                        </tr>
                        </thead>
                        <tbody id="categoryTableBody">
                        <?php foreach ($allDeclinedComments as $comment) : ?>
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <?= $comment['id'] ?>
                                </th>
                                <td class="px-6 py-4">
                                    <?= $comment['client_id'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $comment['comment'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $comment['book_id'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $comment['created_at'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="approve_comment.php?id=<?= $comment['id'] ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2">Approve</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!--                    COMMENTS AWAITING APPROVAL TABLE-->
            <div class="w-full lg:w-1/2 pl-0 lg:pl-2 mt-10">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <h2 class="mb-3 font-bold text-xl">Comments Awaiting Approval</h2>
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-900 uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Client id
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Comment
                            </th>
                            <th scope="col" class="px-6 py-3">
                                book id
                            </th>
                            <th scope="col" class="px-6 py-3">
                                created at
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Approve
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Decline
                            </th>
                        </tr>
                        </thead>
                        <tbody id="authorsTableBody">
                        <?php foreach ($allCommentsPendingApproval as $comment) : ?>
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <?= $comment['id'] ?>
                                </th>
                                <td class="px-6 py-4">
                                    <?= $comment['client_id'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $comment['comment'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $comment['book_id'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $comment['created_at'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="approve_comment.php?id=<?= $comment['id'] ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2">Approve</a>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="decline_comment.php?id=<?= $comment['id'] ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2">Decline</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
require_once "./partials/footer.php";
unset($_SESSION['deletedComment']);
?>
