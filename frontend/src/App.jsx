import './App.css'
import CategoryList from './CategoryList' // Langsung memanggil file yang sejajar dengannya

function App() {
  return (
    <main style={{ padding: '20px', fontFamily: 'sans-serif', maxWidth: '1000px', margin: '0 auto' }}>
      <header style={{ textAlign: 'center', marginBottom: '20px' }}>
        <h1>Sistem Dashboard Toko</h1>
        <p>Integrasi Frontend React ke Database Backend</p>
        <hr />
      </header>
      
      <CategoryList />
    </main>
  )
}

export default App