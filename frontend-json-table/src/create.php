<?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2 class="mb-4">Create New Post</h2>
        <form id="createForm" class="mb-3">
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" id="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <select id="status" class="form-select" required>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                    <option value="trashed">Trashed</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content:</label>
                <textarea id="content" class="form-control" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category:</label>
                <input type="text" id="category" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="index.php" class="btn btn-secondary ms-2">Back</a>
        </form>
        <div id="message"></div>
    </div>
    <script>
        document.getElementById('createForm').addEventListener('submit', function (e) {
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
            fetch('http://127.0.0.1:8081/posts', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(postData)
            })
                .then(response => {
                    if (response.ok) {
                        document.getElementById('message').innerHTML = '<div class="alert alert-success">Post created successfully!</div>';
                        setTimeout(() => window.location.href = 'index.php', 1000);
                    } else {
                        document.getElementById('message').innerHTML = '<div class="alert alert-danger">Failed to create post.</div>';
                    }
                })
                .catch(() => {
                    document.getElementById('message').innerHTML = '<div class="alert alert-danger">Error connecting to server.</div>';
                });
        });
    </script>
</body>

</html>