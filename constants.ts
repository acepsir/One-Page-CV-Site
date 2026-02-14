import { CVData } from './types';

export const INITIAL_DATA: CVData = {
  personalInfo: {
    fullName: "Ahmet Yılmaz",
    title: "Kıdemli Full Stack Geliştirici",
    email: "ahmet@ornek.com",
    phone: "+90 555 123 45 67",
    location: "İstanbul, Türkiye",
    about: "Yenilikçi ve çözüm odaklı yazılım geliştiricisi. 5 yıldan fazla süredir web teknolojileri üzerine çalışıyorum. Karmaşık problemleri basit ve ölçeklenebilir kod yapılarıyla çözmeyi severim. Takım çalışmasına yatkın ve sürekli öğrenmeye açık biriyim.",
    photoUrl: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=500&h=500&q=80"
  },
  skills: [
    {
      id: '1',
      name: 'React & TypeScript',
      level: 5,
      description: 'Modern frontend mimarileri, hook kullanımı ve tip güvenli geliştirme konusunda uzmanım.'
    },
    {
      id: '2',
      name: 'Node.js & Backend',
      level: 4,
      description: 'RESTful API tasarımı, Express.js ve mikroservis mimarileri.'
    },
    {
      id: '3',
      name: 'UI/UX & Tailwind',
      level: 5,
      description: 'Kullanıcı dostu arayüzler ve responsive tasarım prensipleri.'
    },
    {
      id: '4',
      name: 'MySQL & Veritabanı',
      level: 4,
      description: 'Veritabanı normalizasyonu, karmaşık sorgular ve performans optimizasyonu.'
    }
  ],
  experiences: [
    {
      id: '1',
      title: "Kıdemli Frontend Geliştirici",
      company: "Teknoloji Çözümleri A.Ş.",
      period: "2021 - Günümüz",
      description: "Büyük ölçekli e-ticaret projesinin frontend mimarisini yönetiyorum. React performans optimizasyonları ve ekip liderliği yapıyorum."
    },
    {
      id: '2',
      title: "Web Geliştirici",
      company: "Yaratıcı Dijital Ajans",
      period: "2018 - 2021",
      description: "Müşteriler için kurumsal web siteleri ve özel yönetim panelleri geliştirdim. Full-stack sorumluluk aldım."
    }
  ],
  socials: [
    { id: '1', platform: 'LinkedIn', url: 'https://linkedin.com' },
    { id: '2', platform: 'GitHub', url: 'https://github.com' }
  ]
};