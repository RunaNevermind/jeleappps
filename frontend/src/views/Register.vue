<template>
  <div class="container">
    <h1>Регистрация</h1>
    <form @submit.prevent="register">
      <div class="form-group">
        <label for="email">Email</label>
        <input id="email" v-model="form.email" type="email" placeholder="Введите email" required />
        <span v-if="errors.email" class="error">{{ errors.email }}</span>
      </div>

      <div class="form-group">
        <label for="password">Пароль</label>
        <div class="password-wrapper">
          <input id="password" v-model="form.password" :type="showPassword ? 'text' : 'password'" placeholder="Минимум 8 символов" required minlength="8" />
          <button type="button" class="toggle-btn" @click="showPassword = !showPassword">
            {{ showPassword ? '🙈' : '👁' }}
          </button>
        </div>
        <span v-if="errors.password" class="error">{{ errors.password }}</span>
      </div>

      <div class="form-group">
        <label for="gender">Пол</label>
        <select id="gender" v-model="form.gender" required>
          <option value="" disabled>Выберите пол</option>
          <option value="male">Мужской</option>
          <option value="female">Женский</option>
          <option value="other">Другой</option>
        </select>
        <span v-if="errors.gender" class="error">{{ errors.gender }}</span>
      </div>

      <button type="submit" class="submit-btn" :disabled="loading">
        {{ loading ? 'Регистрация...' : 'Зарегистрироваться' }}
      </button>
      <span v-if="errors.server" class="error server-error">{{ errors.server }}</span>
    </form>
  </div>
</template>

<script>
import api from '../services/api.js'

export default {
  name: 'Register',
  data() {
    return {
      form: { email: '', password: '', gender: '' },
      errors: {},
      showPassword: false,
      loading: false,
    }
  },
  methods: {
    validate() {
      this.errors = {}
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      if (!this.form.email) this.errors.email = 'Email обязателен'
      else if (!emailRegex.test(this.form.email)) this.errors.email = 'Некорректный формат email'
      if (!this.form.password) this.errors.password = 'Пароль обязателен'
      else if (this.form.password.length < 8) this.errors.password = 'Пароль должен быть не менее 8 символов'
      if (!this.form.gender) this.errors.gender = 'Выберите пол'
      return Object.keys(this.errors).length === 0
    },
    async register() {
      if (!this.validate()) return
      this.loading = true
      try {
        console.log('=== ЗАПРОС НА РЕГИСТРАЦИЮ ===')
        console.log('URL: POST /api/registration')
        console.log('Body:', JSON.stringify(this.form, null, 2))
        const response = await api.post('/registration', this.form)
        console.log('=== ОТВЕТ СЕРВЕРА ===')
        console.log('Status:', response.status)
        console.log('Data:', JSON.stringify(response.data, null, 2))
        this.$router.push({ name: 'profile', query: { user_id: response.data.user_id } })
      } catch (err) {
        console.error('=== ОШИБКА ===', err)
        if (err.response?.data?.errors) {
          for (const key in err.response.data.errors) this.errors[key] = err.response.data.errors[key][0]
        } else {
          this.errors.server = 'Ошибка сервера.'
        }
      } finally {
        this.loading = false
      }
    },
  },
}
</script>

<style scoped>
.container { max-width: 420px; margin: 80px auto; padding: 32px; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.1); }
h1 { text-align: center; margin-bottom: 24px; color: #1a1a2e; font-size: 24px; }
.form-group { margin-bottom: 18px; }
label { display: block; margin-bottom: 6px; font-weight: 600; color: #333; font-size: 14px; }
input, select { width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 15px; box-sizing: border-box; }
input:focus, select:focus { outline: none; border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.1); }
.password-wrapper { display: flex; gap: 8px; }
.password-wrapper input { flex: 1; }
.toggle-btn { padding: 10px 14px; border: 1px solid #ddd; border-radius: 8px; background: #f9f9f9; cursor: pointer; font-size: 16px; }
.toggle-btn:hover { background: #eee; }
.submit-btn { width: 100%; padding: 12px; background: #4f46e5; color: #fff; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; margin-top: 8px; }
.submit-btn:hover:not(:disabled) { background: #4338ca; }
.submit-btn:disabled { opacity: 0.6; cursor: not-allowed; }
.error { color: #dc2626; font-size: 13px; margin-top: 4px; display: block; }
.server-error { text-align: center; margin-top: 12px; }
</style>