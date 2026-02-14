export interface Skill {
  id: string;
  name: string;
  level: number; // 1 to 5
  description: string;
}

export interface Experience {
  id: string;
  title: string;
  company: string;
  period: string;
  description: string;
}

export interface SocialLink {
  id: string;
  platform: string;
  url: string;
}

export interface PersonalInfo {
  fullName: string;
  title: string;
  email: string;
  phone: string;
  location: string;
  about: string;
  photoUrl: string;
}

export interface CVData {
  personalInfo: PersonalInfo;
  skills: Skill[];
  experiences: Experience[];
  socials: SocialLink[];
}