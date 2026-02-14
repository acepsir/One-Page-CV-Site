import React, { useState } from 'react';
import { CVData, Skill, Experience } from '../types';
import { Save, Plus, Trash2, ChevronDown, ChevronUp } from 'lucide-react';

interface AdminPanelProps {
  data: CVData;
  onUpdate: (newData: CVData) => void;
  onClose: () => void;
}

const AdminPanel: React.FC<AdminPanelProps> = ({ data, onUpdate, onClose }) => {
  const [formData, setFormData] = useState<CVData>(data);
  const [activeTab, setActiveTab] = useState<'personal' | 'skills' | 'experience'>('personal');

  const handlePersonalChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      personalInfo: { ...prev.personalInfo, [name]: value }
    }));
  };

  const handleSkillChange = (index: number, field: keyof Skill, value: string | number) => {
    const newSkills = [...formData.skills];
    newSkills[index] = { ...newSkills[index], [field]: value };
    setFormData(prev => ({ ...prev, skills: newSkills }));
  };

  const addSkill = () => {
    const newSkill: Skill = {
      id: Date.now().toString(),
      name: 'Yeni Yetenek',
      level: 3,
      description: 'Yetenek açıklaması...'
    };
    setFormData(prev => ({ ...prev, skills: [...prev.skills, newSkill] }));
  };

  const removeSkill = (index: number) => {
    setFormData(prev => ({
      ...prev,
      skills: prev.skills.filter((_, i) => i !== index)
    }));
  };

  const handleExperienceChange = (index: number, field: keyof Experience, value: string) => {
    const newExp = [...formData.experiences];
    newExp[index] = { ...newExp[index], [field]: value };
    setFormData(prev => ({ ...prev, experiences: newExp }));
  };

  const addExperience = () => {
    const newExp: Experience = {
      id: Date.now().toString(),
      title: 'Pozisyon Adı',
      company: 'Şirket Adı',
      period: '2023 - 2024',
      description: 'İş tanımı ve sorumluluklar...'
    };
    setFormData(prev => ({ ...prev, experiences: [...prev.experiences, newExp] }));
  };

  const removeExperience = (index: number) => {
    setFormData(prev => ({
      ...prev,
      experiences: prev.experiences.filter((_, i) => i !== index)
    }));
  };

  const handleSave = () => {
    onUpdate(formData);
    onClose();
  };

  return (
    <div className="bg-white min-h-screen pb-20">
      {/* Admin Header */}
      <div className="sticky top-0 z-50 bg-slate-900 text-white px-6 py-4 shadow-md flex justify-between items-center">
        <div>
          <h2 className="text-xl font-bold">Admin Panel</h2>
          <p className="text-slate-400 text-xs">CV Düzenleme Modu</p>
        </div>
        <div className="flex gap-3">
          <button 
            onClick={onClose}
            className="px-4 py-2 rounded-lg text-sm text-slate-300 hover:bg-slate-800 transition-colors"
          >
            İptal
          </button>
          <button 
            onClick={handleSave}
            className="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg text-sm font-medium flex items-center gap-2 transition-colors shadow-lg shadow-indigo-500/30"
          >
            <Save size={16} /> Kaydet & Çık
          </button>
        </div>
      </div>

      <div className="max-w-4xl mx-auto mt-8 px-4">
        
        {/* Tabs */}
        <div className="flex space-x-1 bg-slate-100 p-1 rounded-xl mb-8">
          {[
            { id: 'personal', label: 'Kişisel Bilgiler' },
            { id: 'skills', label: 'Nitelikler' },
            { id: 'experience', label: 'Deneyim' }
          ].map((tab) => (
            <button
              key={tab.id}
              onClick={() => setActiveTab(tab.id as any)}
              className={`flex-1 py-2.5 text-sm font-medium rounded-lg transition-all ${
                activeTab === tab.id 
                ? 'bg-white text-indigo-600 shadow-sm' 
                : 'text-slate-500 hover:text-slate-700'
              }`}
            >
              {tab.label}
            </button>
          ))}
        </div>

        {/* Content */}
        <div className="space-y-6">
          
          {/* PERSONAL INFO TAB */}
          {activeTab === 'personal' && (
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6 animate-fadeIn">
              <div className="md:col-span-2">
                <label className="block text-sm font-medium text-slate-700 mb-1">Profil Fotoğrafı URL</label>
                <input
                  type="text"
                  name="photoUrl"
                  value={formData.personalInfo.photoUrl}
                  onChange={handlePersonalChange}
                  className="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                />
                {formData.personalInfo.photoUrl && (
                  <img src={formData.personalInfo.photoUrl} alt="Preview" className="w-16 h-16 rounded-full mt-2 object-cover border border-slate-200" />
                )}
              </div>
              
              <div>
                <label className="block text-sm font-medium text-slate-700 mb-1">Ad Soyad</label>
                <input
                  type="text"
                  name="fullName"
                  value={formData.personalInfo.fullName}
                  onChange={handlePersonalChange}
                  className="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none"
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-slate-700 mb-1">Ünvan</label>
                <input
                  type="text"
                  name="title"
                  value={formData.personalInfo.title}
                  onChange={handlePersonalChange}
                  className="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none"
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-slate-700 mb-1">E-posta</label>
                <input
                  type="email"
                  name="email"
                  value={formData.personalInfo.email}
                  onChange={handlePersonalChange}
                  className="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none"
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-slate-700 mb-1">Telefon</label>
                <input
                  type="text"
                  name="phone"
                  value={formData.personalInfo.phone}
                  onChange={handlePersonalChange}
                  className="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none"
                />
              </div>

              <div className="md:col-span-2">
                <label className="block text-sm font-medium text-slate-700 mb-1">Konum</label>
                <input
                  type="text"
                  name="location"
                  value={formData.personalInfo.location}
                  onChange={handlePersonalChange}
                  className="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none"
                />
              </div>

              <div className="md:col-span-2">
                <label className="block text-sm font-medium text-slate-700 mb-1">Hakkımda</label>
                <textarea
                  name="about"
                  rows={4}
                  value={formData.personalInfo.about}
                  onChange={handlePersonalChange}
                  className="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none"
                />
              </div>
            </div>
          )}

          {/* SKILLS TAB */}
          {activeTab === 'skills' && (
            <div className="space-y-6">
              {formData.skills.map((skill, index) => (
                <div key={skill.id} className="bg-slate-50 p-6 rounded-xl border border-slate-200 relative group">
                  <button 
                    onClick={() => removeSkill(index)}
                    className="absolute top-4 right-4 text-slate-400 hover:text-red-500 transition-colors p-1"
                  >
                    <Trash2 size={18} />
                  </button>
                  
                  <div className="grid md:grid-cols-2 gap-4 mb-4">
                    <div>
                      <label className="block text-xs font-semibold text-slate-500 uppercase mb-1">Yetenek Adı</label>
                      <input
                        type="text"
                        value={skill.name}
                        onChange={(e) => handleSkillChange(index, 'name', e.target.value)}
                        className="w-full px-3 py-2 rounded border border-slate-300 focus:border-indigo-500 outline-none text-sm"
                      />
                    </div>
                    <div>
                      <label className="block text-xs font-semibold text-slate-500 uppercase mb-1">Seviye (1-5)</label>
                      <input
                        type="number"
                        min="1"
                        max="5"
                        value={skill.level}
                        onChange={(e) => handleSkillChange(index, 'level', parseInt(e.target.value))}
                        className="w-full px-3 py-2 rounded border border-slate-300 focus:border-indigo-500 outline-none text-sm"
                      />
                    </div>
                  </div>
                  <div>
                    <label className="block text-xs font-semibold text-slate-500 uppercase mb-1">Açıklama</label>
                    <input
                      type="text"
                      value={skill.description}
                      onChange={(e) => handleSkillChange(index, 'description', e.target.value)}
                      className="w-full px-3 py-2 rounded border border-slate-300 focus:border-indigo-500 outline-none text-sm"
                    />
                  </div>
                </div>
              ))}
              
              <button 
                onClick={addSkill}
                className="w-full py-3 border-2 border-dashed border-slate-300 rounded-xl text-slate-500 font-medium hover:border-indigo-500 hover:text-indigo-600 transition-colors flex justify-center items-center gap-2"
              >
                <Plus size={20} /> Yeni Yetenek Ekle
              </button>
            </div>
          )}

          {/* EXPERIENCE TAB */}
          {activeTab === 'experience' && (
            <div className="space-y-6">
               {formData.experiences.map((exp, index) => (
                <div key={exp.id} className="bg-slate-50 p-6 rounded-xl border border-slate-200 relative group">
                  <button 
                    onClick={() => removeExperience(index)}
                    className="absolute top-4 right-4 text-slate-400 hover:text-red-500 transition-colors p-1"
                  >
                    <Trash2 size={18} />
                  </button>
                  
                  <div className="grid md:grid-cols-2 gap-4 mb-4">
                    <div>
                      <label className="block text-xs font-semibold text-slate-500 uppercase mb-1">Pozisyon / Ünvan</label>
                      <input
                        type="text"
                        value={exp.title}
                        onChange={(e) => handleExperienceChange(index, 'title', e.target.value)}
                        className="w-full px-3 py-2 rounded border border-slate-300 focus:border-indigo-500 outline-none text-sm"
                      />
                    </div>
                    <div>
                      <label className="block text-xs font-semibold text-slate-500 uppercase mb-1">Şirket</label>
                      <input
                        type="text"
                        value={exp.company}
                        onChange={(e) => handleExperienceChange(index, 'company', e.target.value)}
                        className="w-full px-3 py-2 rounded border border-slate-300 focus:border-indigo-500 outline-none text-sm"
                      />
                    </div>
                     <div className="md:col-span-2">
                      <label className="block text-xs font-semibold text-slate-500 uppercase mb-1">Tarih Aralığı</label>
                      <input
                        type="text"
                        value={exp.period}
                        onChange={(e) => handleExperienceChange(index, 'period', e.target.value)}
                        className="w-full px-3 py-2 rounded border border-slate-300 focus:border-indigo-500 outline-none text-sm"
                        placeholder="Örn: 2020 - 2023"
                      />
                    </div>
                  </div>
                  <div>
                    <label className="block text-xs font-semibold text-slate-500 uppercase mb-1">Açıklama</label>
                    <textarea
                      rows={3}
                      value={exp.description}
                      onChange={(e) => handleExperienceChange(index, 'description', e.target.value)}
                      className="w-full px-3 py-2 rounded border border-slate-300 focus:border-indigo-500 outline-none text-sm resize-none"
                    />
                  </div>
                </div>
              ))}
              
              <button 
                onClick={addExperience}
                className="w-full py-3 border-2 border-dashed border-slate-300 rounded-xl text-slate-500 font-medium hover:border-indigo-500 hover:text-indigo-600 transition-colors flex justify-center items-center gap-2"
              >
                <Plus size={20} /> Yeni Deneyim Ekle
              </button>
            </div>
          )}

        </div>
      </div>
    </div>
  );
};

export default AdminPanel;