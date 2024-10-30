document.addEventListener('DOMContentLoaded', () => {
    const html = document.documentElement;
    const sunIcon = document.querySelector('.theme-icon-light');
    const moonIcon = document.querySelector('.theme-icon-dark');
    const themeToggle = document.getElementById('theme-toggle');
    
    // Kiểm tra xem có tìm thấy moon icon không
    console.log('Moon icon:', moonIcon);
    console.log('Moon icon display:', getComputedStyle(moonIcon).display);
    
    // Đảm bảo icon moon không bị ẩn khi khởi tạo
    moonIcon.style.cssText = 'display: none';
    sunIcon.style.cssText = 'display: inline-block';
    
    // Khởi tạo theme từ localStorage
    const savedTheme = localStorage.getItem('theme') || 'light';
    setThemeAndIcons(savedTheme);
    
    // Xử lý click event
    themeToggle.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        
        const currentTheme = localStorage.getItem('theme') || 'light';
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        
        // Log trạng thái trước khi thay đổi
        console.log('Changing theme to:', newTheme);
        console.log('Moon icon before change:', getComputedStyle(moonIcon).display);
        
        setThemeAndIcons(newTheme);
        
        // Log trạng thái sau khi thay đổi
        setTimeout(() => {
            console.log('Moon icon after change:', getComputedStyle(moonIcon).display);
        }, 100);
        
        return false;
    }, true);
    
    function setThemeAndIcons(theme) {
        localStorage.setItem('theme', theme);
        html.setAttribute('data-bs-theme', theme);
        
        if (theme === 'dark') {
            console.log('Setting dark theme - showing moon icon');
            moonIcon.style.cssText = 'display: inline-block !important; opacity: 1';
            sunIcon.style.cssText = 'display: none !important; opacity: 0';
        } else {
            console.log('Setting light theme - hiding moon icon');
            moonIcon.style.cssText = 'display: none !important; opacity: 0';
            sunIcon.style.cssText = 'display: inline-block !important; opacity: 1';
        }
    }
});
