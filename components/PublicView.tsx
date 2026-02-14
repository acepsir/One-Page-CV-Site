import React from 'react';
import { CVData } from '../types';
import { MapPin, Mail, Phone, Star, Briefcase, User } from 'lucide-react';

interface PublicViewProps {
  data: CVData;
}

const StarRating: React.FC<{ level: number }> = ({ level }) => {
  return (
    <div className="flex gap-1 text-yellow-400">
      {[...Array(5)].map((_, i) => (
        <Star
          key={i}
          size={16}
          fill={i < level ? "currentColor" : "none"}
          className={i < level ? "text-yellow-400" : "text-gray-300"}
        />
      ))}
    </div>
  );
};

const PublicView: React.FC<PublicViewProps> = ({ data }) => {
  const { personalInfo, skills, experiences } = data;

  return (
    <div className="max-w-5xl mx-auto bg-white shadow-xl min-h-screen flex flex-col md:flex-row overflow-hidden rounded-lg my-8">
      {/* Sidebar / Left Column */}
      <aside className="w-full md:w-1/3 bg-slate-900 text-white p-8 flex flex-col">
        <div className="flex flex-col items-center text-center mb-8">
          <div className="w-40 h-40 rounded-full border-4 border-white/20 overflow-hidden mb-6 shadow-lg">
            <img 
              src={personalInfo.photoUrl} 
              alt={personalInfo.fullName} 
              className="w-full h-full object-cover"
            />
          </div>
          <h1 className="text-2xl font-bold mb-2">{personalInfo.fullName}</h1>
          <p className="text-indigo-400 font-medium uppercase tracking-wide text-sm mb-6">
            {personalInfo.title}
          </p>
        </div>

        <div className="space-y-6">
          <div className="flex flex-col gap-4">
            <h3 className="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-700 pb-2">
              İletişim
            </h3>
            
            <div className="flex items-center gap-3 text-slate-300 text-sm hover:text-white transition-colors">
              <div className="bg-slate-800 p-2 rounded-lg">
                <Mail size={16} />
              </div>
              <span>{personalInfo.email}</span>
            </div>

            <div className="flex items-center gap-3 text-slate-300 text-sm hover:text-white transition-colors">
               <div className="bg-slate-800 p-2 rounded-lg">
                <Phone size={16} />
              </div>
              <span>{personalInfo.phone}</span>
            </div>

            <div className="flex items-center gap-3 text-slate-300 text-sm hover:text-white transition-colors">
               <div className="bg-slate-800 p-2 rounded-lg">
                <MapPin size={16} />
              </div>
              <span>{personalInfo.location}</span>
            </div>
          </div>

          <div className="mt-8">
            <h3 className="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-700 pb-2 mb-4">
              Hakkımda
            </h3>
            <p className="text-slate-300 text-sm leading-relaxed">
              {personalInfo.about}
            </p>
          </div>
        </div>
      </aside>

      {/* Main Content / Right Column */}
      <main className="w-full md:w-2/3 p-8 md:p-12 bg-white">
        
        {/* Experience Section */}
        <section className="mb-12">
          <div className="flex items-center gap-3 mb-6">
            <div className="p-2 bg-indigo-100 text-indigo-600 rounded-lg">
              <Briefcase size={24} />
            </div>
            <h2 className="text-2xl font-bold text-slate-800">Deneyimler</h2>
          </div>

          <div className="space-y-8 border-l-2 border-indigo-100 pl-8 ml-3 relative">
            {experiences.map((exp) => (
              <div key={exp.id} className="relative">
                <span className="absolute -left-[39px] top-1 w-5 h-5 rounded-full border-4 border-white bg-indigo-500"></span>
                <h3 className="text-lg font-bold text-slate-800">{exp.title}</h3>
                <div className="flex justify-between items-center text-sm text-slate-500 mb-2 font-medium">
                  <span>{exp.company}</span>
                  <span className="bg-slate-100 px-2 py-0.5 rounded text-xs">{exp.period}</span>
                </div>
                <p className="text-slate-600 text-sm leading-relaxed">
                  {exp.description}
                </p>
              </div>
            ))}
          </div>
        </section>

        {/* Skills Section */}
        <section>
          <div className="flex items-center gap-3 mb-6">
             <div className="p-2 bg-indigo-100 text-indigo-600 rounded-lg">
              <User size={24} />
            </div>
            <h2 className="text-2xl font-bold text-slate-800">Nitelikler & Yetenekler</h2>
          </div>

          <div className="grid grid-cols-1 gap-6">
            {skills.map((skill) => (
              <div key={skill.id} className="bg-slate-50 p-5 rounded-xl border border-slate-100 hover:border-indigo-200 transition-colors">
                <div className="flex justify-between items-start mb-2">
                  <h4 className="font-bold text-slate-800">{skill.name}</h4>
                  <StarRating level={skill.level} />
                </div>
                <p className="text-sm text-slate-600">
                  {skill.description}
                </p>
              </div>
            ))}
          </div>
        </section>

      </main>
    </div>
  );
};

export default PublicView;