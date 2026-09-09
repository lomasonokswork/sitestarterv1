const toggleBtn = document.getElementById('theme-toggle');
  const root = document.documentElement;

  if (localStorage.getItem('theme') === 'dark') {
    root.classList.add('dark');
    toggleBtn.setAttribute('aria-pressed', 'true');
  }

  toggleBtn.addEventListener('click', () => {
    root.classList.toggle('dark');
    const dark = root.classList.contains('dark');
    localStorage.setItem('theme', dark ? 'dark' : 'light');
    toggleBtn.setAttribute('aria-pressed', dark);
  });

  document.addEventListener('click', (e) => {
  if (e.target.closest('.copy-btn')) {
    const btn = e.target.closest('.copy-btn');
    const url = btn.getAttribute('data-url');
    const font = btn.getAttribute('data-font');
    const textToCopy = url || font;
    
    navigator.clipboard.writeText(textToCopy)
      .then(() => {
        toast.textContent = 'Copied!';
        toast.classList.add('show');
        setTimeout(() => {
          toast.classList.remove('show');
        }, 2000);
      })
      .catch(err => {
        console.error('Failed to copy:', err);
      });
  }
});

document.addEventListener('DOMContentLoaded', function() {
  const filterSections = document.querySelectorAll('.filter-section');
  
  filterSections.forEach(section => {
    const button = section.querySelector('.expand-button');
    const options = section.querySelector('.filter-options');
    const title = section.querySelector('.filter-title');
    
    title.addEventListener('click', function() {
      button.classList.toggle('collapsed');
      options.classList.toggle('collapsed');
      
      const isCollapsed = button.classList.contains('collapsed');
      button.setAttribute('aria-label', isCollapsed ? 'Expand' : 'Collapse');
    });
  });

  //saved funkcionalitate
  document.querySelectorAll('.save-btn').forEach(button => {
  button.addEventListener('click', function() {
    const projectName = this.getAttribute('data-project');
    const isSaved = this.getAttribute('data-saved') === 'true';
    const action = isSaved ? 'unsave' : 'save';
    const icon = this.querySelector('i');
    
    fetch('save_project.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `project_name=${encodeURIComponent(projectName)}&action=${action}`
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        if (action === 'save') {
          this.setAttribute('data-saved', 'true');
          icon.className = 'fas fa-bookmark';
        } else {
          this.setAttribute('data-saved', 'false');
          icon.className = 'far fa-bookmark';
        }
      } else if (data.message === 'Please login first') {
        window.location.href = 'login.php';
      }
    });
  });
});
});
