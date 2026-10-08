<template>
  <div class="container">
    <div v-if="loading" class="loading">Загрузка профиля...</div>
    <div v-else-if="user" class="profile-card">
      <h1>Профиль пользователя</h1>
      <div class="profile-info">
        <div class="info-row"><span class="label">ID:</span><span class="value">{{ user.id }}</span></div>
        <div class="info-row"><span class="label">Email:</span><span class="value">{{ user.email }}</span></div>
        <div class="info-row"><span class="label">Пол:</span><span class="value">{{ genderLabel(user.gender) }}</span></div>
        <div class="info-row"><span class="label">Дата регистрации:</span><span class="value">{{ user.created_at }}</span></div>
      </div>
      <button class="back-btn" @click="$router.push('/')">Назад к регистрации</button>
    </div>
    <div v-else class="error-state">
      <p>Пользователь не найден</p>
      <button class="back-btn" @click="$router.push('/')">Назад к регистрации</button>
    </div>
  </div>
</template>

<script>
import api from '../services/api.js'
export default {
  name: 'Profile',
  data() { return { user: null, loading: true } },
  async mounted() {
    const userId = this.$route.query.user_id
    if (!userId) { this.loading = false; return }
    try {
      const response = await api.get('/profile', { params: { user_id: userId } })
      this.user = response.data
    } catch (err) { console.error('Ошибка:', err) }
    finally { this.loading = false }
  },
  methods: {
    genderLabel(g) { return { male: 'Мужской', female: 'Женский', other: 'Другой' }[g] || g },
  },
}
</script>

<style scoped>
.container { max-width: 480px; margin: 80px auto; padding: 32px; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.1); }
h1 { text-align: center; margin-bottom: 24px; color: #1a1a2e; font-size: 24px; }
.loading { text-align: center; color: #666; padding: 40px 0; }
.profile-info { display: flex; flex-direction: column; gap: 16px; }
.info-row { display: flex; justify-content: space-between; padding: 12px 16px; background: #f8f9fa; border-radius: 8px; }
.label { font-weight: 600; color: #555; }
.value { color: #1a1a2e; }
.back-btn { width: 100%; padding: 12px; margin-top: 24px; background: #6b7280; color: #fff; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; }
.back-btn:hover { background: #4b5563; }
.error-state { text-align: center; color: #dc2626; }
</style>