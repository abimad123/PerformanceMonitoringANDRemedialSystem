import React, { useState, useEffect } from 'react';
import { useNavigate, useParams, Link } from 'react-router-dom';
import subjectService from '../../services/subjectService';
import SubjectForm from './components/SubjectForm';

const SubjectEditPage = () => {
  const navigate = useNavigate();
  const { id } = useParams();
  const [formData, setFormData] = useState({
    name: '',
    code: '',
    class: '',
    type: '',
    max_marks: 100,
    is_active: true,
  });
  const [errors, setErrors] = useState({});
  const [loading, setLoading] = useState(false);
  const [fetching, setFetching] = useState(true);

  useEffect(() => {
    const fetchSubject = async () => {
      try {
        const response = await subjectService.getSubject(id);
        setFormData({
          name: response.data.name || '',
          code: response.data.code || '',
          class: String(response.data.class) || '',
          type: response.data.type || '',
          max_marks: response.data.max_marks ?? 100,
          is_active: !!response.data.is_active,
        });
      } catch (err) {
        console.error('Error fetching subject details:', err);
        alert('Could not load subject details.');
        navigate('/subjects');
      } finally {
        setFetching(false);
      }
    };
    fetchSubject();
  }, [id, navigate]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setErrors({});

    try {
      await subjectService.updateSubject(id, formData);
      navigate('/subjects', { state: { successMessage: 'Subject updated successfully.' } });
    } catch (err) {
      if (err.response?.status === 422) {
        setErrors(err.response.data.errors || {});
      } else {
        console.error('Error updating subject:', err);
        alert(err.response?.data?.message || 'Something went wrong while saving updates.');
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <>
      <div className="page-header" style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
        <div>
          <h2 className="page-title">Edit Subject</h2>
          <p className="page-subtitle">Update details for {fetching ? '...' : formData.name}</p>
        </div>
        <Link to="/subjects" className="btn btn-outline">
          Back to Subjects
        </Link>
      </div>

      <div className="card" style={{ maxWidth: '640px', marginTop: '24px' }}>
        {fetching ? (
          <div style={{ textAlign: 'center', padding: '40px 0', color: '#64748b' }}>
            <p>Loading subject details...</p>
          </div>
        ) : (
          <SubjectForm
            formData={formData}
            setFormData={setFormData}
            onSubmit={handleSubmit}
            errors={errors}
            loading={loading}
            submitLabel="Update Subject"
            isEdit={true}
          />
        )}
      </div>
    </>
  );
};

export default SubjectEditPage;
