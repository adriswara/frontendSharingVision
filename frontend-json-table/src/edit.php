<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Edit Post</h2>
    <form id="editForm" class="mb-3">
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" id="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Current Status:</label>
            <input type="text" id="status" class="form-control" readonly>
            <br>
            <button type="button" class="btn btn-sm btn-primary" onclick="setStatus('Published')">Publish</button> <button type="button"
                class="btn btn-sm btn-warning" onclick="setStatus('Draft')">Draft</button> <button type="button"
                class="btn btn-sm btn-danger" onclick="setStatus('Trashed')"><i class="bi bi-trash"></i></button>

        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content:</label>
            <textarea id="content" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category:</label>
            <input type="text" id="category" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary ms-2">Back</a>
    </form>
    <div id="message"></div>
</div>
<script>
    // Get post ID from URL: edit.php?id=123
    function getPostId() {
        const params = new URLSearchParams(window.location.search);
        return params.get('id');
    }

    const postId = getPostId();
    if (!postId) {
        document.getElementById('message').innerHTML = '<div class="alert alert-danger">No post ID provided.</div>';
        document.getElementById('editForm').style.display = 'none';
    } else {
        // Fetch post data and fill form
        fetch(`http://127.0.0.1:8081/posts/${postId}`)
            .then(response => response.json())
            .then(post => {
                document.getElementById('title').value = post.title || '';
                document.getElementById('status').value = post.status || 'draft';
                document.getElementById('content').value = post.content || '';
                document.getElementById('category').value = post.category || '';
            })
            .catch(() => {
                document.getElementById('message').innerHTML = '<div class="alert alert-danger">Failed to load post data.</div>';
                document.getElementById('editForm').style.display = 'none';
            });

        // Handle form submit
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // validation

            // Get values
            const title = document.getElementById('title').value.trim();
            const content = document.getElementById('content').value.trim();
            const category = document.getElementById('category').value.trim();

            // Validation
            let errorMsg = '';
            if (title.length < 20) {
                errorMsg += 'Title must be at least 20 characters.<br>';
            }
            if (content.length < 200) {
                errorMsg += 'Content must be at least 200 characters.<br>';
            }
            if (category.length < 3) {
                errorMsg += 'Category must be at least 3 characters.<br>';
            }

            if (errorMsg) {
                document.getElementById('message').innerHTML = `<div class="alert alert-danger">${errorMsg}</div>`;
                return;
            }

            //validation

            const postData = {
                title,
                status: document.getElementById('status').value,
                content,
                category,
                created_date: new Date().toISOString()
            };
            fetch(`http://127.0.0.1:8081/posts/${postId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(postData)
                })
                .then(response => {
                    if (response.ok) {
                        document.getElementById('message').innerHTML = '<div class="alert alert-success">Post updated successfully!</div>';
                        setTimeout(() => window.location.href = 'index.php', 1000);
                    } else {
                        document.getElementById('message').innerHTML = '<div class="alert alert-danger">Failed to update post.</div>';
                    }
                })
                .catch(() => {
                    document.getElementById('message').innerHTML = '<div class="alert alert-danger">Error connecting to server.</div>';
                });
        });
    }

    function setStatus(newStatus) {
        document.getElementById('status').value = newStatus;
    }
</script>
</body>

</html>