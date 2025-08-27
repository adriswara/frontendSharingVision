<?php include 'header.php'; ?>
<div class="container mt-5">
    <h1 class="mb-4">Posts</h1>

    <!-- Dropdown Filter -->
    <div class="mb-3">
        <label for="statusFilter" class="form-label">Filter by Status:</label>
        <select id="statusFilter" class="form-select w-auto">
            <option value="all">All</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
            <option value="trashed">Trashed</option>
        </select>
    </div>
    <div>
        <a href="create.php" class="btn btn-primary mb-3">Add New Post</a>
    </div>

    <!-- Table -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Content</th>
                <th>Category</th>
                <th>Created Date</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody id="posts"></tbody>
    </table>
</div>

<script>
    let allPosts = [];

    // Fetch posts from API
    fetch('http://127.0.0.1:8081/posts')
        .then(response => response.json())
        .then(data => {
            allPosts = data;
            renderPosts(allPosts);
        });

    // Render posts to table
    function renderPosts(posts) {
        const tbody = document.getElementById('posts');
        tbody.innerHTML = '';
        posts.forEach(post => {
            tbody.innerHTML += `
                    <tr>
                        <td><strong>${post.title}</strong></td>
                        <td>${post.status}</td>
                        <td>${post.content}</td>
                        <td>${post.category}</td>
                        <td>${new Date(post.created_date).toLocaleString()}</td>
                        <td>
                            <a href="edit.php?id=${post.id}" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                        <td>
                             <button class="btn btn-sm btn-danger" onclick="deletePost(${post.id})"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                `;
        });
    }

    // soft Delete post
    function deletePost(id) {
        if (!confirm('Anda yakin ingin menghapus data ini?')) return;
        fetch(`http://127.0.0.1:8081/posts/delete/${id}`, {
                method: 'PUT'
            })
            .then(response => {
                if (response.ok) {
                    // Remove the deleted post from allPosts and re-render
                    // allPosts = allPosts.filter(post => post.id !== id);
                    // renderPosts(allPosts);
                     alert('Status Post diubah ke Trashed.');
                } else {
                    alert('Gagal menghapus data.');
                }
            })
            .catch(() => alert('Terjadi kesalahan saat menghapus data.'));
    }

    // drodown filter event
    document.getElementById('statusFilter').addEventListener('change', function() {
        const selected = this.value;
        if (selected === 'all') {
            renderPosts(allPosts);
        } else {
            const filtered = allPosts.filter(post => post.status.toLowerCase() === selected);
            renderPosts(filtered);
        }
    });
</script>
</body>

</html>