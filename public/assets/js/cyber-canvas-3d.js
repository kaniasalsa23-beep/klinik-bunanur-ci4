/**
 * CyberCanvas3D - Interactive 3D Floating Particles & Medical Molecular Nodes (Light Mode)
 * Antigravity Medical Glassmorphism Design System
 * Theme: Elegant Rose Pink (#f43f5e), Soft Pink (#ec4899), & Warm Gold (#f59e0b)
 */
(function() {
    'use strict';

    function initCyberCanvas() {
        let canvas = document.getElementById('bg-particles') ||
                     document.getElementById('cyberCanvas3D') ||
                     document.getElementById('cyberCanvas');
        if (!canvas) {
            canvas = document.createElement('canvas');
            canvas.id = 'bg-particles';
            document.body.prepend(canvas);
        }

        // Enforce consistent viewport positioning
        canvas.style.position = 'fixed';
        canvas.style.top = '0';
        canvas.style.left = '0';
        canvas.style.width = '100vw';
        canvas.style.height = '100vh';
        canvas.style.pointerEvents = 'none';
        canvas.style.zIndex = '0';

        const ctx = canvas.getContext('2d');
        if (!ctx) return;

        let width = canvas.width = window.innerWidth;
        let height = canvas.height = window.innerHeight;

        const particles = [];
        const particleCount = Math.min(Math.floor((width * height) / 16000), 65);
        const connectionDistance = 140;
        const mouse = { x: -1000, y: -1000, radius: 150 };

        // Elegant Light Mode Color palette
        const colors = [
            'rgba(244, 63, 94, ',   // Rose Pink
            'rgba(236, 72, 153, ',  // Soft Pink
            'rgba(251, 113, 133, ', // Light Rose
            'rgba(245, 158, 11, '   // Soft Warm Gold
        ];

        class Particle3D {
            constructor() {
                this.reset(true);
            }

            reset(initial = false) {
                this.x = Math.random() * width;
                this.y = initial ? Math.random() * height : (Math.random() > 0.5 ? -10 : height + 10);
                this.z = Math.random() * 400 + 100; // 3D depth simulation
                this.baseRadius = Math.random() * 2.5 + 1.2;
                this.colorPrefix = colors[Math.floor(Math.random() * colors.length)];
                
                // 3D velocities (gentle float)
                this.vx = (Math.random() - 0.5) * 0.45;
                this.vy = (Math.random() - 0.5) * 0.45;
                this.vz = (Math.random() - 0.5) * 0.35;
                this.pulseSpeed = 0.02 + Math.random() * 0.03;
                this.pulsePhase = Math.random() * Math.PI * 2;
            }

            update() {
                this.x += this.vx;
                this.y += this.vy;
                this.z += this.vz;

                // 3D depth oscillation
                if (this.z < 80 || this.z > 500) this.vz *= -1;

                // Screen boundaries
                if (this.x < -30) this.x = width + 30;
                if (this.x > width + 30) this.x = -30;
                if (this.y < -30) this.y = height + 30;
                if (this.y > height + 30) this.y = -30;

                // Mouse magnetic repulsion
                const dx = mouse.x - this.x;
                const dy = mouse.y - this.y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < mouse.radius) {
                    const force = (1 - dist / mouse.radius) * 1.4;
                    this.x -= (dx / (dist || 1)) * force;
                    this.y -= (dy / (dist || 1)) * force;
                }

                this.pulsePhase += this.pulseSpeed;
            }

            draw() {
                const scale = 300 / this.z;
                const radius = Math.max(0.8, this.baseRadius * scale + Math.sin(this.pulsePhase) * 0.35);
                const alpha = Math.min(0.65, Math.max(0.12, (1 - this.z / 520) * 0.6));

                ctx.save();
                ctx.beginPath();
                ctx.arc(this.x, this.y, radius, 0, Math.PI * 2);

                // Elegant glowing soft pink sphere
                ctx.fillStyle = this.colorPrefix + alpha + ')';
                ctx.shadowBlur = radius * 3;
                ctx.shadowColor = this.colorPrefix + '0.5)';
                ctx.fill();
                ctx.restore();
            }
        }

        // Initialize particles
        for (let i = 0; i < particleCount; i++) {
            particles.push(new Particle3D());
        }

        // Draw connections with soft filaments
        function drawConnections() {
            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    const p1 = particles[i];
                    const p2 = particles[j];

                    const dx = p1.x - p2.x;
                    const dy = p1.y - p2.y;
                    const dz = (p1.z - p2.z) * 0.4;
                    const dist = Math.sqrt(dx * dx + dy * dy + dz * dz);

                    if (dist < connectionDistance) {
                        const alpha = (1 - dist / connectionDistance) * 0.16;
                        const grad = ctx.createLinearGradient(p1.x, p1.y, p2.x, p2.y);
                        grad.addColorStop(0, p1.colorPrefix + alpha + ')');
                        grad.addColorStop(1, p2.colorPrefix + alpha + ')');

                        ctx.beginPath();
                        ctx.moveTo(p1.x, p1.y);
                        ctx.lineTo(p2.x, p2.y);
                        ctx.strokeStyle = grad;
                        ctx.lineWidth = Math.max(0.4, (1 - (p1.z + p2.z) / 1000) * 1.1);
                        ctx.stroke();
                    }
                }
            }
        }

        // Animation Loop
        function animate() {
            ctx.clearRect(0, 0, width, height);

            drawConnections();

            for (let i = 0; i < particles.length; i++) {
                particles[i].update();
                particles[i].draw();
            }

            requestAnimationFrame(animate);
        }

        animate();

        // Resize Listener
        window.addEventListener('resize', () => {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
        });

        window.addEventListener('mousemove', (e) => {
            mouse.x = e.clientX;
            mouse.y = e.clientY;
        });

        window.addEventListener('mouseleave', () => {
            mouse.x = -1000;
            mouse.y = -1000;
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCyberCanvas);
    } else {
        initCyberCanvas();
    }
})();
