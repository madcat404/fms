class SessionManager {
    constructor(timeoutDuration) {
        this.timeoutDuration = timeoutDuration; // 밀리초 단위 (9시간 = 9 * 60 * 60 * 1000)
        this.timer = null;
        this.lastActivity = new Date();
        
        // 이벤트 리스너 등록
        this.setupEventListeners();
        // 초기 타이머 시작
        this.resetTimer();
    }

    setupEventListeners() {
        // 사용자 활동 감지
        const events = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart'];
        events.forEach(event => {
            document.addEventListener(event, () => this.resetTimer());
        });

        // 페이지 가시성 변경 감지
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) {
                this.checkSessionStatus();
            }
        });
    }

    resetTimer() {
        if (this.timer) {
            clearTimeout(this.timer);
        }
        
        this.lastActivity = new Date();
        this.timer = setTimeout(() => this.checkSessionStatus(), this.timeoutDuration);
    }

    async checkSessionStatus() {
        try {
            const response = await fetch('/session/session_check.php', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await response.json();
            
            if (!data.valid) {
                alert(data.message);
                window.location.href = '/login.php';
            }
        } catch (error) {
            console.error('세션 상태 확인 중 오류 발생:', error);
            window.location.href = '/login.php';
        }
    }
}

// PHP의 timeout_duration(32400초)과 동일하게 설정
const sessionManager = new SessionManager(32400 * 1000);