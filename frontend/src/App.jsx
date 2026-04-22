import { motion } from "motion/react";
import { Star, ChevronRight, Zap, BarChart3, Users, ShieldCheck, ArrowRight, PlayCircle, Quote, CheckCircle2, FileText, BookOpen } from "lucide-react";
import { useState } from "react";

const BASE_URL = import.meta.env.VITE_BACKEND_URL;

const VIDEO_URL =
  "https://d8j0ntlcm91z4.cloudfront.net/user_38xzZboKViGWJOttwIXH07lWA1P/hf_20260302_085640_276ea93b-d7da-4418-a09b-2aa5b490e838.mp4";

const NavButton = ({ children, className = "" }) => (
  <button className={`
    relative overflow-hidden
    font-geist font-medium text-[14px] tracking-tight
    px-6 py-2.5 rounded-full
    bg-[#0b0d12] text-white
    border border-white/10
    shadow-[0_1px_2px_rgba(0,0,0,0.1),inset_0_1px_0_rgba(255,255,255,0.1)]
    hover:shadow-[0_8px_20px_-4px_rgba(0,0,0,0.3),inset_0_1px_0_rgba(255,255,255,0.15)]
    hover:border-white/20
    transition-all duration-300 ease-[cubic-bezier(0.23,1,0.32,1)]
    active:scale-[0.97]
    group
    ${className}
  `}>
    {/* Subtle shimmer effect on hover */}
    <div className="absolute inset-0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000 ease-in-out bg-gradient-to-r from-transparent via-white/10 to-transparent z-0" />
    
    <span className="relative z-10 flex items-center gap-2">
      {children}
    </span>
  </button>
);

export default function App() {
  const [email, setEmail] = useState("");

  const handleCreateAccount = () => {
    const registerUrl = new URL(`${BASE_URL}/register`);
    if (email) {
      registerUrl.searchParams.append("email", email);
    }
    window.location.href = registerUrl.toString();
  };

  return (
    <section className="relative min-h-screen w-full overflow-hidden bg-white selection:bg-[#8e2de2] selection:text-white">
      {/* Enhanced Glass Navbar */}
      <nav className="fixed top-6 left-1/2 -translate-x-1/2 z-50 w-full max-w-[1300px] px-4 md:px-6">
        <div className="flex items-center justify-between bg-white/40 backdrop-blur-3xl border border-white/40 rounded-full px-4 md:px-8 py-3 shadow-[0_8px_32px_0_rgba(31,38,135,0.15),inset_0_1px_2px_rgba(255,255,255,0.5)]">
          <div className="flex items-center gap-2">
            <div className="w-30 h-10 shrink-0">
              <img src="/logo.png" alt="PMRS Logo" className="w-full h-full object-contain bg-transparent" referrerPolicy="no-referrer" />
            </div>
         
          </div>

          <div className="flex items-center gap-4 md:gap-8">
            <div className="hidden md:flex items-center gap-8">
              {["Platform Features", "For Educators", "Success Stories", "Resources"].map((item) => (
                <a
                  key={item}
                  href={`#${item.toLowerCase().replace(/\s+/g, '-')}`}
                  className="text-[14px] font-medium text-[#1a1a1a]/70 hover:text-black transition-colors"
                >
                  {item}
                </a>
              ))}
            </div>
           <a href={`${BASE_URL}/login`}>
  <NavButton>
    Sign In
    <ChevronRight className="w-4 h-4 text-white/70 group-hover:text-white transition-colors" />
  </NavButton>
</a>
          </div>
        </div>
      </nav>

      {/* Background video */}
      <div className="absolute inset-0 z-0">
        <video
          className="[transform:scaleY(-1)]"
          src={VIDEO_URL}
          autoPlay
          muted
          loop
          playsInline
        />
        <div className="absolute inset-0 bg-gradient-to-b from-[26.416%] from-[rgba(255,255,255,0)] to-[66.943%] to-white" />
      </div>

      {/* Content */}
      <div
        className="relative z-10 mx-auto flex max-w-[1200px] flex-col items-center gap-8 px-6 text-center pt-[180px] md:pt-[290px]"
      >
          {/* Main Heading */}
          <motion.h1
            initial={{ opacity: 0, scale: 0.96, y: 32 }}
            animate={{ opacity: 1, scale: 1, y: 0 }}
            transition={{ duration: 0.9, ease: [0.22, 1, 0.36, 1] }}
            className="font-bold text-[#111113] tracking-[-0.06em] px-4 md:px-0"
            style={{
              fontFamily: "'Geist', sans-serif",
              fontSize: "clamp(40px, 9vw, 150px)",
              lineHeight: 0.9,
              textAlign: "center",
            }}
          >
            Automate{" "}
            <span
              className="italic text-transparent bg-clip-text bg-gradient-to-br from-[#1a1a1a] via-[#444] to-[#888]"
              style={{
                fontFamily: "'Instrument Serif', serif",
                fontSize: "1.15em",
                fontWeight: 400,
                letterSpacing: "-0.01em",
                display: "inline-block",
                transform: "translateY(0.04em)",
              }}
            >
              improvement
            </span>{" "}
            <br />
            for every student
          </motion.h1>

          <motion.p
            initial={{ opacity: 0, y: 24 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8, delay: 0.15, ease: [0.22, 1, 0.36, 1] }}
            className="text-slate-custom/80 font-normal leading-relaxed text-[16px] md:text-[20px] max-w-[640px]"
            style={{
              fontFamily: "'Geist', sans-serif",
            }}
          >
            PMRS <span className="text-[#111113] font-bold">(Performance Monitoring & Remedial System)</span> is the modern, trusted, and fully automated solution for academic improvement. 
            From gap analysis to remedial execution, we handle it all effortlessly.
          </motion.p>

        <motion.div
          initial={{ opacity: 0, y: 24 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.7, delay: 0.3, ease: [0.22, 1, 0.36, 1] }}
          className="flex flex-col items-center gap-5"
        >
         <div
  className="flex flex-col sm:flex-row items-center gap-2 bg-[#ffffff] border border-black/10 p-2 sm:pl-6 w-full max-w-[460px] transition-all duration-200 focus-within:shadow-[0px_12px_50px_8px_rgba(0,0,0,0.08)]"
  style={{
    borderRadius: "40px",
    boxShadow: "0px 10px 40px 5px rgba(150, 33, 228, 0.76)",
  }}
>
  <input
    type="email"
    placeholder="Enter your work email"
    value={email}
    onChange={(e) => setEmail(e.target.value)}
    className="
      flex-1 
      bg-transparent 
      outline-none 
      text-[15px] 
      text-[#111] 
      placeholder:text-[#9aa0ad] 
      w-full 
      px-4 py-3 sm:px-0 sm:py-0
    "
    style={{
      fontFamily: "'Geist', sans-serif",
      fontWeight: 500,
      letterSpacing: "-0.01em"
    }}
  />

  <button
    onClick={handleCreateAccount}
    className="rounded-full px-5 py-3 text-white text-[14px] font-medium transition-transform active:scale-[0.98] w-full sm:w-auto"
    style={{
      fontFamily: "'Geist', sans-serif",
      background: "linear-gradient(180deg, #2a2a2e 0%, #131316 100%)",
      boxShadow:
        "inset -4px -6px 25px 0px rgba(201,201,201,0.08), inset 4px 4px 10px 0px rgba(29,29,29,0.24)",
    }}
  >
    Create Free Account
  </button>
</div>
          
          <motion.p 
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ delay: 0.5 }}
            className="text-[12px] text-[#1a1a1a]/40 font-medium tracking-tight"
          >
            No credit card required • Secure 14-day free trial
          </motion.p>

          {/* Social proof */}
          <div className="flex items-center gap-3">
            <div className="flex -space-x-2">
              {["#f59e0b", "#ef4444", "#3b82f6", "#10b981"].map((c, i) => (
                <div
                  key={i}
                  className="h-7 w-7 rounded-full border-2 border-white"
                  style={{ background: c }}
                />
              ))}
            </div>
            <div className="flex items-center gap-1">
              {Array.from({ length: 5 }).map((_, i) => (
                <Star key={i} className="h-4 w-4 fill-[#f5b400] text-[#f5b400]" />
              ))}
            </div>
            <span
              className="text-[14px] text-[#373a46]"
              style={{ fontFamily: "'Geist', sans-serif" }}
            >
              <span className="font-semibold">1,020+</span> Reviews
            </span>
          </div>
        </motion.div>
      </div>

      {/* Hero Dashboard Preview */}
      <section className="relative z-10 px-6 pt-20 pb-10">
        <motion.div
           initial={{ opacity: 0, y: 40 }}
           whileInView={{ opacity: 1, y: 0 }}
           viewport={{ once: true }}
           transition={{ duration: 1, ease: [0.22, 1, 0.36, 1] }}
           className="mx-auto max-w-[1200px]"
        >
          <div className="flex flex-col items-center gap-4 text-center mb-16">
            <h2 className="text-3xl md:text-5xl font-medium tracking-tight text-[#1a1a1a] font-geist">Powerful Insights at Your Fingertips</h2>
            <p className="text-slate-custom/60 text-lg max-w-2xl leading-relaxed">
              Take a closer look at our intuitive dashboard designed to give you a comprehensive view 
              of student performance and remedial progress in one unified interface.
            </p>
          </div>

          <div className="relative p-2 md:p-4 bg-white/50 backdrop-blur-sm border border-black/5 rounded-[40px] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.1)] group">
             {/* Play Overlay */}
             <div className="absolute inset-0 z-20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none">
                <div className="flex flex-col items-center gap-4">
                  <div className="w-20 h-20 rounded-full bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center text-white scale-90 group-hover:scale-100 transition-transform duration-500">
                    <PlayCircle className="w-10 h-10 fill-white" />
                  </div>
                  <span className="text-white font-semibold tracking-wider uppercase text-xs">Watch Demo</span>
                </div>
             </div>

             <div className="overflow-hidden rounded-[32px] border border-black/5 bg-[#09090b] group-hover:scale-[0.99] transition-transform duration-700 ease-out">
                <div className="flex items-center justify-between px-6 py-4 border-b border-white/5">
                   <div className="flex gap-2">
                      <div className="w-2.5 h-2.5 rounded-full bg-red-500/20" />
                      <div className="w-2.5 h-2.5 rounded-full bg-yellow-500/20" />
                      <div className="w-2.5 h-2.5 rounded-full bg-green-500/20" />
                   </div>
                   <div className="px-3 py-1 rounded-full bg-white/5 border border-white/10 text-[10px] text-white/40 uppercase tracking-widest font-bold">
                      Master Dashboard
                   </div>
                </div>
                <div className="p-6 md:p-10 grid md:grid-cols-12 gap-8">
                   <div className="md:col-span-8 flex flex-col gap-6">
                      <div className="grid grid-cols-3 gap-4">
                         {[1,2,3].map(i => (
                           <div key={i} className="bg-white/5 rounded-2xl p-4 border border-white/5">
                              <div className="h-1.5 w-12 bg-white/10 rounded-full mb-3" />
                              <div className="h-4 w-20 bg-white/20 rounded-full" />
                           </div>
                         ))}
                      </div>
                      <div className="flex-1 min-h-[240px] bg-white/[0.02] rounded-3xl border border-white/5 p-6 relative overflow-hidden">
                         <div className="absolute inset-0 flex items-end px-4 pb-8 gap-2">
                            {[40, 65, 35, 90, 55, 80, 45, 70].map((h, i) => (
                               <motion.div 
                                 key={i} 
                                 initial={{ height: 0 }}
                                 whileInView={{ height: `${h}%` }}
                                 className="flex-1 bg-gradient-to-t from-[#8e2de2]/40 to-transparent rounded-t-lg" 
                               />
                            ))}
                         </div>
                         <div className="absolute top-6 left-6 flex flex-col gap-2">
                            <div className="h-2 w-32 bg-white/20 rounded-full" />
                            <div className="h-1.5 w-24 bg-white/10 rounded-full" />
                         </div>
                      </div>
                   </div>
                   <div className="md:col-span-4 flex flex-col gap-6">
                      <div className="bg-white/5 rounded-3xl p-6 border border-white/5 flex flex-col gap-4">
                         <div className="h-1.5 w-1/2 bg-white/20 rounded-full" />
                         <div className="flex flex-col gap-3">
                            {[1,2,3,4].map(i => (
                               <div key={i} className="flex items-center gap-3">
                                  <div className="w-8 h-8 rounded-lg bg-white/5 border border-white/5" />
                                  <div className="flex-1 h-1.5 bg-white/10 rounded-full" />
                               </div>
                            ))}
                         </div>
                      </div>
                      <div className="flex-1 bg-[#1a1a1a] rounded-3xl border border-white/10 p-6 flex flex-col justify-center items-center text-center gap-4">
                         <Zap className="w-8 h-8 text-[#8e2de2]" />
                         <div className="flex flex-col gap-2">
                            <div className="h-2 w-24 bg-white/20 rounded-full mx-auto" />
                            <div className="h-1.5 w-32 bg-white/10 rounded-full mx-auto" />
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
        </motion.div>
      </section>

      {/* Key Features Section */}
      <section id="platform-features" className="relative z-10 mx-auto max-w-[1200px] px-6 py-20 md:py-40 bg-white">
        <motion.div 
          initial={{ opacity: 0, y: 40 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true, amount: 0.1 }}
          transition={{ duration: 0.8, ease: [0.22, 1, 0.36, 1] }}
          className="flex flex-col gap-16"
        >
          <div className="flex flex-col gap-4 text-center items-center">
            <motion.span 
              initial={{ opacity: 0, scale: 0.95 }}
              whileInView={{ opacity: 1, scale: 1 }}
              viewport={{ once: true }}
              className="px-4 py-1.5 rounded-full bg-black/5 text-[#1a1a1a] text-xs font-semibold uppercase tracking-widest"
            >
              Platform Excellence
            </motion.span>
            <h2 className="text-4xl md:text-5xl font-medium tracking-tight text-[#1a1a1a] font-geist">Key Features</h2>
          </div>

          <div className="grid md:grid-cols-3 gap-8">
            {[
              {
                icon: <Zap className="w-6 h-6" />,
                title: "Recover Learning Hours",
                desc: "Identify critical academic weaknesses within seconds using our proprietary pattern-recognition engine."
              },
              {
                icon: <BarChart3 className="w-6 h-6" />,
                title: "Predict Excellence",
                desc: "Transform simple test scores into actionable growth maps with beautiful, high-fidelity visualizations."
              },
              {
                icon: <ShieldCheck className="w-6 h-6" />,
                title: "Secure Every Data Point",
                desc: "Enterprise-grade encryption and privacy controls ensure student data remains protected and compliant."
              }
            ].map((feature, i) => (
              <motion.div 
                key={i}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ duration: 0.5, delay: i * 0.1 }}
                className="group p-8 rounded-[32px] border border-black/10 hover:border-black/20 hover:shadow-2xl hover:shadow-black/15 transition-all duration-500 bg-white shadow-xl shadow-black/[0.03]"
              >
                <div className="w-12 h-12 rounded-2xl bg-black/5 flex items-center justify-center text-black group-hover:bg-black group-hover:text-white transition-colors duration-500 mb-6">
                  {feature.icon}
                </div>
                <h3 className="font-geist font-semibold text-xl text-[#1a1a1a] mb-3">{feature.title}</h3>
                <p className="font-geist text-slate-custom/70 leading-relaxed">
                  {feature.desc}
                </p>
              </motion.div>
            ))}
          </div>
        </motion.div>
      </section>

      {/* For Educators Section */}
      <section id="for-educators" className="relative z-10 mx-auto max-w-[1200px] px-6 py-20 md:py-40">
        <motion.div 
          initial={{ opacity: 0, y: 40 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true, amount: 0.1 }}
          transition={{ duration: 0.8, ease: [0.22, 1, 0.36, 1] }}
          className="grid lg:grid-cols-2 gap-20 items-center"
        >
          <div className="order-2 lg:order-1 relative p-4 bg-[#fcfcfc] rounded-[48px] border border-black/[0.03]">
             <div className="relative rounded-[40px] overflow-hidden aspect-[4/3] shadow-2xl">
                <img src="https://picsum.photos/seed/educator-premium/1200/900" className="w-full h-full object-cover" referrerPolicy="no-referrer" />
                <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent" />
                <div className="absolute bottom-8 left-8 right-8 flex flex-col gap-2">
                   <div className="flex -space-x-3">
                      {[1,2,3].map(i => (
                        <div key={i} className="w-10 h-10 rounded-full border-2 border-white bg-slate-200 overflow-hidden shadow-lg">
                           <img src={`https://picsum.photos/seed/face${i}/80/80`} className="w-full h-full object-cover" referrerPolicy="no-referrer" />
                        </div>
                      ))}
                      <div className="w-10 h-10 rounded-full border-2 border-white bg-black flex items-center justify-center text-white text-[10px] font-bold shadow-lg">+42</div>
                   </div>
                   <p className="text-white text-sm font-medium">Join 500+ schools using PMRS</p>
                </div>
             </div>
             
           
          </div>
          <div className="order-1 lg:order-2 flex flex-col gap-10">
            <div className="flex flex-col gap-6">
              <span className="text-black/50 text-sm font-bold uppercase tracking-[0.2em] px-4 py-1.5 rounded-full border border-black/5 w-fit">Teacher Empowerment</span>
              <h2 className="text-5xl md:text-6xl font-medium tracking-tight text-[#111113] font-geist leading-[1.1]">The Precision Tool for Every Teacher</h2>
              <p className="text-xl text-slate-custom/70 leading-relaxed max-w-lg">
                PMRS eliminates the admin burden, giving teachers more time for what matters most: direct student impact.
              </p>
            </div>
            
            <div className="grid sm:grid-cols-2 gap-x-12 gap-y-10">
              {[
                { title: "Smart Assessment", desc: "Automated benchmarks tailored to curriculum." },
                { title: "Course Routing", desc: "Send one-click remedial plans to students." },
                { title: "Live Insights", desc: "Track classroom progress in real-time." },
                { title: "Team Sync", desc: "Collaborate across departments effortlessly." }
              ].map((item, i) => (
                <div key={i} className="flex flex-col gap-3 border-l-2 border-black/10 pl-6 hover:border-black transition-colors group">
                  <h4 className="font-bold text-[#111113] font-geist group-hover:text-black transition-colors">{item.title}</h4>
                  <p className="text-slate-custom/60 text-sm leading-relaxed">{item.desc}</p>
                </div>
              ))}
            </div>
            
            <div className="flex flex-col sm:flex-row gap-4 pt-4">
               <NavButton className="w-full sm:w-fit">Explore Educator Tools</NavButton>
               <button className="px-8 py-3 rounded-full border border-black/10 font-medium hover:bg-black hover:text-white transition-all font-geist text-sm">Schedule Demo</button>
            </div>
          </div>
        </motion.div>
      </section>

      {/* How it Works Section */}
      <section className="relative z-10 bg-[#f9f9fb] py-20 md:py-40 overflow-hidden text-[#1a1a1a]">
        <motion.div 
          initial={{ opacity: 0, scale: 0.98, y: 30 }}
          whileInView={{ opacity: 1, scale: 1, y: 0 }}
          viewport={{ once: true, amount: 0.1 }}
          transition={{ duration: 1, ease: [0.22, 1, 0.36, 1] }}
          className="mx-auto max-w-[1200px] px-6"
        >
          <div className="grid lg:grid-cols-2 gap-24 items-center">
            <div className="flex flex-col gap-8">
              <div className="flex flex-col gap-4 text-left">
                <motion.span 
                  initial={{ opacity: 0, x: -10 }}
                  whileInView={{ opacity: 1, x: 0 }}
                  viewport={{ once: true }}
                  className="text-black/40 text-sm font-semibold uppercase tracking-widest flex items-center gap-2"
                >
                  <PlayCircle className="w-4 h-4" /> The Workflow
                </motion.span>
                <h2 className="text-4xl md:text-5xl font-medium tracking-tight text-[#1a1a1a] font-geist">How PMRS Works</h2>
                <p className="text-lg text-slate-custom/70 leading-relaxed max-w-lg">
                  Designed for administrators and educators who value precision. Our three-step 
                  process automates the path from monitoring to success.
                </p>
              </div>

              <div className="flex flex-col gap-12">
                {[
                  { step: "01", title: "Global Integration", desc: "Connect your existing student database. PMRS seamlessly ingests data without manual entry." },
                  { step: "02", title: "Pattern Discovery", desc: "Our automated system scans for learning plateaus and suggests immediate remedial actions." },
                  { step: "03", title: "Execution & Results", desc: "Distribute remedial material and track new progress markers in real-time." }
                ].map((s, i) => (
                  <motion.div 
                    key={i}
                    initial={{ opacity: 0, x: -20 }}
                    whileInView={{ opacity: 1, x: 0 }}
                    viewport={{ once: true }}
                    transition={{ delay: i * 0.15 }}
                    className="flex gap-6 items-start"
                  >
                    <span className="font-instrument text-4xl text-black/10">{s.step}</span>
                    <div className="flex flex-col gap-1 pt-1">
                      <h4 className="font-semibold text-lg text-[#1a1a1a] font-geist">{s.title}</h4>
                      <p className="text-slate-custom/60 leading-relaxed tracking-tight">{s.desc}</p>
                    </div>
                  </motion.div>
                ))}
              </div>
            </div>

            <motion.div 
              initial={{ opacity: 0, scale: 0.9 }}
              whileInView={{ opacity: 1, scale: 1 }}
              viewport={{ once: true }}
              transition={{ duration: 1 }}
              className="relative aspect-square bg-[#19181a] rounded-[48px] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.4)] p-8 border border-white/10 overflow-hidden"
            >
               <div className="absolute inset-0 opacity-40">
                  <div className="absolute top-[-10%] right-[-10%] w-[80%] h-[80%] bg-[#8e2de2]/20 rounded-full blur-[120px]" />
                  <div className="absolute bottom-[-10%] left-[-10%] w-[60%] h-[60%] bg-[#4a00e0]/20 rounded-full blur-[100px]" />
               </div>
               
               <div className="relative h-full w-full flex flex-col gap-4">
                  {/* Mock Dashboard Header */}
                  <div className="flex justify-between items-center bg-white/5 p-4 rounded-2xl border border-white/10">
                    <div className="flex gap-2">
                       <div className="w-2 h-2 rounded-full bg-red-500/50" />
                       <div className="w-2 h-2 rounded-full bg-yellow-500/50" />
                       <div className="w-2 h-2 rounded-full bg-green-500/50" />
                    </div>
                    <div className="h-2 w-24 bg-white/10 rounded-full" />
                  </div>

                  {/* Mock Content Area */}
                  <div className="flex-1 grid grid-cols-2 gap-4">
                    <div className="bg-white/5 rounded-3xl p-6 border border-white/10 flex flex-col gap-4">
                       <div className="h-2 w-1/2 bg-[#8e2de2]/40 rounded-full" />
                       <div className="flex-1 flex items-end gap-1">
                          {[40, 70, 45, 90, 60].map((h, i) => (
                             <div key={i} className="flex-1 bg-white/10 rounded-t-sm" style={{ height: `${h}%` }} />
                          ))}
                       </div>
                    </div>
                    <div className="flex flex-col gap-4">
                       <div className="flex-1 bg-white/5 rounded-3xl border border-white/10 p-4 flex flex-col justify-center gap-3">
                          <div className="h-1.5 w-full bg-white/10 rounded-full" />
                          <div className="h-1.5 w-[80%] bg-white/10 rounded-full" />
                          <div className="h-1.5 w-[60%] bg-white/10 rounded-full" />
                       </div>
                       <div className="h-20 bg-[#8e2de2]/20 rounded-2xl border border-[#8e2de2]/20 p-4 flex items-center justify-center">
                          <Zap className="w-6 h-6 text-[#8e2de2]" />
                       </div>
                    </div>
                  </div>
                  
                  {/* Status Bar */}
                  <div className="h-12 bg-white/5 rounded-2xl border border-white/10 flex items-center px-4 gap-3">
                    <div className="w-2 h-2 rounded-full bg-emerald-500 animate-pulse" />
                    <div className="h-1.5 w-32 bg-white/10 rounded-full" />
                  </div>
               </div>
            </motion.div>
          </div>
        </motion.div>
      </section>

      {/* Testimonials Section */}
      <section id="success-stories" className="relative z-10 mx-auto max-w-[1200px] px-6 py-20 md:py-40">
        <motion.div 
          initial={{ opacity: 0, y: 40 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true, amount: 0.1 }}
          transition={{ duration: 0.8, ease: [0.22, 1, 0.36, 1] }}
          className="flex flex-col gap-16"
        >
          <div className="flex flex-col gap-4 text-center items-center">
            <Quote className="w-8 h-8 text-black/10" />
            <h2 className="text-3xl md:text-5xl font-medium tracking-tight text-[#1a1a1a] font-geist italic leading-tight">What Educators Say</h2>
          </div>

          <div className="grid md:grid-cols-2 gap-6 md:gap-8">
            {[
              {
                quote: "PMRS converted our tedious monitoring process into a 15-minute weekly review. The automated remedial suggestions are incredibly accurate.",
                author: "Dr. Sarah Jenkins",
                role: "Director of Academics, Oxford Academy"
              },
              {
                quote: "The interface is premium, the speed is unmatched, and the impact on our students' scores was immediate. A must-have for modern institutions.",
                author: "Marcus Chen",
                role: "Dean of Studies, Silverline Tech"
              }
            ].map((t, i) => (
              <motion.div 
                key={i}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ duration: 0.5, delay: i * 0.1 }}
                className="p-8 md:p-12 rounded-[32px] md:rounded-[40px] bg-white border border-black/5 flex flex-col gap-6 md:gap-8 justify-between hover:border-black/20 transition-all duration-300 shadow-sm hover:shadow-xl"
              >
                <p className="text-xl md:text-2xl font-instrument leading-tight italic text-[#1a1a1a]">
                   "{t.quote}"
                </p>
                <div className="flex items-center gap-4 border-t border-black/5 pt-6">
                  <div className="w-10 h-10 md:w-12 md:h-12 rounded-full bg-slate-100 overflow-hidden shrink-0">
                    <img src={`https://picsum.photos/seed/quote${i}/100/100`} className="w-full h-full object-cover" referrerPolicy="no-referrer" />
                  </div>
                  <div className="flex flex-col overflow-hidden">
                    <span className="font-semibold text-[#1a1a1a] truncate">{t.author}</span>
                    <span className="text-[12px] md:text-sm text-slate-custom/60 uppercase tracking-widest truncate">{t.role}</span>
                  </div>
                </div>
              </motion.div>
            ))}
          </div>
        </motion.div>
      </section>

      {/* Resources Section */}
      <section id="resources" className="relative z-10 bg-white py-24 md:py-48 overflow-hidden text-[#111113]">
        <motion.div 
           initial={{ opacity: 0, y: 40 }}
           whileInView={{ opacity: 1, y: 0 }}
           viewport={{ once: true, amount: 0.1 }}
           transition={{ duration: 0.8, ease: [0.22, 1, 0.36, 1] }}
           className="relative z-10 mx-auto max-w-[1240px] px-6"
        >
          <div className="flex flex-col md:flex-row justify-between items-end gap-10 mb-20 border-b border-black/[0.05] pb-10">
            <div className="flex flex-col gap-4 max-w-xl">
               <span className="text-black/40 text-sm font-bold uppercase tracking-widest px-4 py-1.5 rounded-full border border-black/5 w-fit">Expert Knowledge</span>
               <h2 className="text-5xl md:text-6xl font-medium tracking-tight font-geist leading-[1]">Resources & Insights</h2>
               <p className="text-black/60 text-lg md:text-xl font-geist">Expert analysis and implementation strategies for building the next generation of academic excellence.</p>
            </div>
            <button className="flex items-center gap-3 px-8 py-4 rounded-full bg-black text-white font-medium hover:bg-black/80 transition-all group shrink-0">
               Browse Library <ArrowRight className="w-5 h-5 group-hover:translate-x-2 transition-transform" />
            </button>
          </div>

          <div className="grid md:grid-cols-3 gap-10">
            {[
              { 
                type: "Whitepaper", 
                title: "The Future of Automated Pedagogy", 
                readTime: "12 min read",
                icon: <FileText className="w-5 h-5" />,
                desc: "Exploring how pattern-recognition engines are reshaping standardized testing benchmarks.",
                tag: "Academic Trend"
              },
              { 
                type: "Guide", 
                title: "Implementing PMRS in Your Institution", 
                readTime: "8 min read",
                icon: <BookOpen className="w-5 h-5" />,
                desc: "A step-by-step roadmap for technical integration and data onboarding across departments.",
                tag: "Implementation"
              },
              { 
                type: "Case Study", 
                title: "How Silverline Tech gained 24% Efficiency", 
                readTime: "15 min read",
                icon: <Users className="w-5 h-5" />,
                desc: "An in-depth look at the quantitative results achieved by leading technical institutions.",
                tag: "Client Success"
              }
            ].map((res, i) => (
              <motion.div 
                key={i} 
                whileHover={{ y: -8 }}
                className="group flex flex-col p-10 bg-transparent border border-black/[0.08] rounded-[40px] hover:bg-[#fcfcfc] hover:border-black transition-all cursor-pointer shadow-sm hover:shadow-xl hover:shadow-black/5"
              >
                 <div className="flex flex-col gap-8 h-full justify-between">
                    <div className="flex flex-col gap-6">
                       <div className="flex justify-between items-start">
                          <div className="w-10 h-10 rounded-xl bg-black text-white flex items-center justify-center">
                             {res.icon}
                          </div>
                          <span className="text-[11px] font-bold uppercase tracking-widest text-black/30 border border-black/5 px-3 py-1 rounded-full">{res.type}</span>
                       </div>
                       
                       <div className="flex flex-col gap-3">
                          <h3 className="text-2xl font-semibold leading-tight font-geist group-hover:text-black transition-colors">{res.title}</h3>
                          <p className="text-black/50 text-[15px] leading-relaxed line-clamp-2">{res.desc}</p>
                       </div>
                    </div>
                    
                    <div className="flex justify-between items-center text-sm font-medium text-black/40 border-t border-black/5 pt-6 group-hover:border-black/10 transition-colors">
                       <div className="flex items-center gap-2">
                          <PlayCircle className="w-4 h-4 opacity-40" />
                          <span>{res.readTime}</span>
                       </div>
                       <div className="w-8 h-8 rounded-full border border-black/10 flex items-center justify-center group-hover:bg-black group-hover:text-white group-hover:border-black transition-all duration-300">
                          <ArrowRight className="w-4 h-4" />
                       </div>
                    </div>
                 </div>
              </motion.div>
            ))}
          </div>
        </motion.div>
      </section>

      {/* Editorial Footer */}
      <footer className="relative w-full bg-[#ffeadf] pt-24 pb-12 overflow-hidden">
        <motion.div 
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.8, ease: [0.22, 1, 0.36, 1] }}
          className="relative z-10 mx-auto max-w-[1400px] px-8"
        >
          <div className="flex flex-col gap-6">
            {/* Top Section: Logo + Links */}
      {/* Top Section */}
<div className="max-w-[1000px] mx-auto grid grid-cols-1 lg:grid-cols-5 gap-12 items-start">

  {/* Logo */}
  <div className="lg:col-span-1 flex justify-center lg:justify-start">
    <img
      src="/logo.png"
      alt="PMRS Logo"
      className="h-12 object-contain"
    />
  </div>

  {/* Links */}
  <div className="lg:col-span-4 grid grid-cols-2 sm:grid-cols-4 gap-x-10 gap-y-8 text-left">
    {[
      {
        title: "Product",
        links: ["How it works", "Features", "Pricing", "FAQ"]
      },
      {
        title: "Company",
        links: ["About", "Careers", "Brand", "Contact"]
      },
      {
        title: "Resources",
        links: ["Download", "Terms of Use", "Privacy Policy", "Support"]
      },
      {
        title: "Connect",
        links: ["X (Twitter)", "Instagram", "LinkedIn", "YouTube"]
      }
    ].map((col) => (
      <div key={col.title} className="flex flex-col gap-3">
        <span className="text-[12px] font-bold uppercase tracking-widest text-[#19181a]/50">
          {col.title}
        </span>
        <div className="flex flex-col gap-2">
          {col.links.map((link) => (
            <a
              key={link}
              href="#"
              className="text-[15px] font-medium text-[#19181a] hover:opacity-60 transition-opacity"
            >
              {link}
            </a>
          ))}
        </div>
      </div>
    ))}
  </div>

</div>

            {/* Bottom Row: Legal + Massive Branding */}
            <div className="flex flex-col w-full border-t border-[#19181a]/5 pt-0">
              <div className="relative w-full select-none pointer-events-none">
                <h1 className="text-[28vw] font-bold leading-[0.8] tracking-[-0.04em] text-[#19181a] text-center whitespace-nowrap opacity-100 translate-y-[35%] font-sansation uppercase">
                  PMRS
                </h1>
              </div>
            </div>
          </div>
        </motion.div>
      </footer>
    </section>

  );
}
