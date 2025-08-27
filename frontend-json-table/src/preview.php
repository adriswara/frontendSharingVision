<?php include 'header.php'; ?>

    <div class="container mt-5">
        <div id="posts" class="row gy-4"></div>
        <div id="expandedPost"></div>
    </div>
    <script>
        let allPosts = [];
        let expandedId = null;

        fetch('http://127.0.0.1:8081/posts')
            .then(response => response.json())
            .then(data => {
                allPosts = data.filter(post => post.status === 'Published');
                renderPosts(allPosts);
            });

        function renderPosts(posts) {
            const container = document.getElementById('posts');
            container.innerHTML = '';
            posts.forEach(post => {
                container.innerHTML += `
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">${post.title}</h5>
                            <span class="badge bg-secondary mb-2">${post.category}</span>
                           <!-- <span class="badge bg-info mb-2">${post.status}</span> -->
                            <p class="card-text">${post.content.substring(0, 100)}${post.content.length > 100 ? '...' : ''}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <small class="text-muted">${new Date(post.created_date).toLocaleString()}</small>
                            <div>
                                <button type="button" class="btn btn-sm btn-warning" onclick="expandPost(${post.id})">Read</button>
                            </div>
                        </div>
                    </div>
                </div>
                `;
            });
            renderExpanded();
        }

        function expandPost(id) {
            expandedId = id;
            renderExpanded();
            window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
        }

        function renderExpanded() {
            const expandedContainer = document.getElementById('expandedPost');
            if (!expandedId) {
                expandedContainer.innerHTML = '';
                return;
            }
            const post = allPosts.find(p => p.id === expandedId);
            if (!post) return;
            expandedContainer.innerHTML = `
                <div class="card mt-4 border-primary shadow-lg">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <span>${post.title}</span>
                        <button type="button" class="btn btn-sm btn-light" onclick="closeExpanded()">Close</button>
                    </div>
                    <div class="card-body">
                        <span class="badge bg-secondary mb-2">${post.category}</span>
                        <span class="badge bg-info mb-2">${post.status}</span>
                        <p class="card-text">${post.content}</p>
                    </div>
                    <div class="card-footer text-muted">
                        ${new Date(post.created_date).toLocaleString()}
                    </div>
                </div>
            `;
        }

        function closeExpanded() {
            expandedId = null;
            renderExpanded();
        }

        document.getElementById('statusFilter')?.addEventListener('change', function () {
            const selected = this.value;
            expandedId = null;
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