<?php
require_once "./partials/header.php";
session_start();
require_once "./partials/navbar.php";
require_once "./Books/Book.php";
require_once "./Comments/Comment.php";

use Books\Book as Book;
use Comments\Comment;

$book = new Book();
$id = $_GET['id'];
$book->setId(intval($id));
$bookDetails = $book->getBookById();

$comment = new Comment();
$comment->setBookID($_GET['id']);
$comment->setClientID($_SESSION['user']['id']);
$allApprovedComments = $comment->getAllApprovedCommentsByBookID();
$allClientsComments = $comment->getAllClientsCommentsByBookID();
?>

<div class="flex-grow">
    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row -mx-4">
                <div class="md:flex-1 px-4">
                    <div class="h-[460px] rounded-lg bg-gray-300 mb-4">
                        <img class="w-full h-full object-cover"
                             src="<?= $bookDetails['cover_img_url'] ?>"
                             alt="Product Image">
                    </div>
                </div>
                <div class="md:flex-1 px-4">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2"><?= $bookDetails['title'] ?></h2>
                    <p class="text-gray-600 text-sm mb-2"><?= $bookDetails['book_author_name'], ' ', $bookDetails['book_author_lastname'] ?></p>
                    <p class="text-gray-600 text-sm mb-4"><i
                                class="far fa-bookmark mr-2"></i><?= $bookDetails['book_category_title'] ?></p>
                    <div class="flex mb-4">
                        <div class="mr-4">
                            <span class="font-bold text-gray-700">Published in:</span>
                            <span class="text-gray-600"><?= $bookDetails['published_in'] ?></span>
                        </div>
                        <div>
                            <span class="font-bold text-gray-700">Total Pages:</span>
                            <span class="text-gray-600"><?= $bookDetails['total_pages'] ?></span>
                        </div>
                    </div>
                    <div>
                        <span class="font-bold text-gray-700">About the author:</span>
                        <p class="text-gray-600 text-sm mt-2"><?= $bookDetails['book_author_bio'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <section class="bg-white py-8 lg:py-16 antialiased">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-4 grid-cols-1">
                <?php if (isset($_SESSION['user'])) : ?>
                    <div>
                        <h2 class="text-lg lg:text-2xl font-bold text-gray-900 mb-4">Add a comment</h2>
                        <form class="mb-6" method="POST" action="./add_comment.php?id= <?= $bookDetails['id'] ?>">
                            <div class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border <?= isset($_SESSION['commentError']) ? 'border-red-500' : 'border-gray-200' ?>">
                                <input type="text" name="bookID" value="<?= $id ?>" hidden="">
                                <label for="comment" class="sr-only">Your comment</label>
                                <textarea id="comment" rows="6" <?= count($allClientsComments) == 2 ? 'disabled' : '' ?>
                                  class="px-0 w-full text-sm text-gray-900 focus:ring-0 focus:outline-none border-0"
                                  <?= count($allClientsComments) == 2 ? 'placeholder="You have reached the maximum number of comments!"'  : 'placeholder="Write a comment..."' ?> name="comment" required></textarea>
                            </div>
                            <button type="submit"
                                    class="inline-flex items-center py-2.5 px-4 text-xs font-bold text-center text-white bg-indigo-600 rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-primary-800" <?= count($allClientsComments) == 2 ? 'disabled' : '' ?>>
                                Post comment
                            </button>
                        </form>
                    </div>
                    <div>
                        <h2 class="text-lg lg:text-2xl font-bold text-gray-900 mb-4">Add a note</h2>
                        <form class="mb-6" id="noteForm">
                            <input type="text" id="noteID" name="noteID" hidden="">
                            <input type="text" id="bookID" name="bookID" value="<?= $_GET['id'] ?>" hidden="">
                            <input type="text" id="clientID" name="clientID" value="<?= $_SESSION['user']['id'] ?>" hidden="">
                            <div class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200">
                                <label for="noteInput" class="sr-only">Your note</label>
                                <textarea id="noteInput" rows="6"
                                          class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none"
                                          placeholder="Write a note..." required></textarea>
                                <p class="text-red-500 text-xs italic notes-error"></p>
                            </div>

                            <button type="submit" id="noteSubmitBtn"
                                    class="inline-flex items-center py-2.5 px-4 text-xs font-bold text-center text-white bg-yellow-500 rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-primary-800">
                                Add note
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>

            <div class="notes mb-6" id="listAllNotes">
                <article class="p-3 text-base bg-white rounded-lg">
                    <footer class="flex justify-between items-center mb-2">
                        <div class="flex items-center">
                            <p class="inline-flex items-center mr-3 text-sm text-gray-900 font-semibold">Michael Gough</p>
                            <p class="text-sm text-gray-600">
                                <time pubdate datetime="2022-02-08"
                                      title="February 8th, 2022">Feb. 8, 2022
                                </time>
                            </p>
                        </div>
                    </footer>
                    <p class="text-gray-600">Very straight-to-point article. Really worth time reading. Thank
                        you! But tools are just the
                        instruments for the UX designers. The knowledge of the design tools are as important as the
                        creation of the design strategy.</p>
                </article>
            </div>

            <div class="comments">
                <h2 class="text-lg lg:text-xl font-bold text-gray-900 mb-1">Comments</h2>
                <?php foreach ($allApprovedComments as $comment) : ?>
                    <article class="p-3 text-base bg-white rounded-lg">
                        <footer class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <p class="inline-flex items-center mr-3 text-sm text-gray-900 font-semibold"><?= $comment['client_comment_name'] . ' ' . $comment['client_comment_lastname'] ?></p>
                                <p class="text-sm text-gray-600">
                                    <?php
                                    $datetime = $comment['created_at'];
                                    $date = (new DateTime($datetime))->format('M. j. Y')
                                    ?>
                                    <time><?= $date ?> </time>
                                </p>
                            </div>
                        </footer>
                        <p class="text-gray-600"><?= $comment['comment'] ?></p>
                    </article>
                <?php endforeach; ?>

                <?php foreach ($allClientsComments as $comment) : ?>
                    <article class="p-3 text-base bg-white rounded-lg">
                        <footer class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <p class="inline-flex items-center mr-3 text-sm text-gray-900 font-semibold"><?= $comment['client_comment_name'] . ' ' . $comment['client_comment_lastname'] ?></p>
                                <p class="text-sm text-gray-600">
                                    <?php
                                    $datetime = $comment['created_at'];
                                    $date = (new DateTime($datetime))->format('M. j. Y')
                                    ?>
                                    <time><?= $date ?> </time>
                                </p>
                                <?php if ($comment['client_id'] == $_SESSION['user']['id']) : ?>
                                    <p class="text-sm text-blue-600 dark:text-blue-500 hover:underline ml-2"><a href="./delete-comment.php?id=<?= $_GET['id'] ?>&&commentId=<?= $comment['id'] ?>">Delete</a></p>
                                <?php endif; ?>
                                <p class="text-sm text-gray-600 ml-2">
                                    Status: <?php if($comment['is_approved'] == 0) {
                                        echo '<span class="text-yellow-600">Pending Approval</span>';
                                    } else if ($comment['is_approved'] == 1) {
                                        echo '<span class="text-green-500">Approved</span>';
                                    } else if ($comment['is_approved'] == 2) {
                                        echo '<span class="text-red-500">Declined</span>';
                                    }
                                    ?>
                                </p>
                            </div>
                        </footer>
                        <p class="text-gray-600"><?= $comment['comment'] ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>


<script>
    // Pass the userId from PHP session to JavaScript
    let clientId = <?php echo json_encode(intval($_SESSION['user']['id'])) ?>;
</script>
<script src="./js/notes.js"></script>
<?php
require_once "./partials/footer.php";
unset($_SESSION['commentError'])
?>

