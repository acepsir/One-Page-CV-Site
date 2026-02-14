import React, { useState, useEffect } from 'react';
import PublicView from './components/PublicView';
import AdminPanel from './components/AdminPanel';
import { CVData } from './types';
import { INITIAL_DATA } from './constants';
import { Settings } from 'lucide-react';

const App: React.FC = () => {
  const [isAdmin, setIsAdmin] = useState<boolean>(false);
  const [cvData, setCvData] = useState<CVData>(INITIAL_DATA);
  const [isLoaded, setIsLoaded] = useState(false);

  // Load data from localStorage on mount
  useEffect(() => {
    const savedData = localStorage.getItem('cv_data');
    if (savedData) {
      try {
        setCvData(JSON.parse(savedData));
      } catch (e) {
        console.error("Failed to parse saved data", e);
      }
    }
    setIsLoaded(true);
  }, []);

  // Save data to localStorage whenever it changes
  useEffect(() => {
    if (isLoaded) {
      localStorage.setItem('cv_data', JSON.stringify(cvData));
    }
  }, [cvData, isLoaded]);

  if (!isLoaded) return null;

  return (
    <div className="relative min-h-screen bg-slate-50">
      
      {isAdmin ? (
        <AdminPanel 
          data={cvData} 
          onUpdate={(newData) => {
            setCvData(newData);
            setIsAdmin(false);
          }}
          onClose={() => setIsAdmin(false)}
        />
      ) : (
        <>
          <PublicView data={cvData} />
          
          {/* Admin Toggle Button (Floating) */}
          <button
            onClick={() => setIsAdmin(true)}
            className="fixed bottom-6 right-6 bg-indigo-600 text-white p-4 rounded-full shadow-xl hover:bg-indigo-700 hover:scale-105 transition-all z-40 group"
            title="Admin Paneli"
          >
            <Settings size={24} className="group-hover:rotate-90 transition-transform duration-500" />
          </button>
        </>
      )}
    </div>
  );
};

export default App;