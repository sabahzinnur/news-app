import { httpGet, httpPost } from '@/common/http.js'

export async function updateUserProfile (formData) {
  const response = await httpPost('/profile', formData)
  return response.data
}

export async function getUserProfile () {
  const response = await httpGet('/profile')
  return response.data
}

export async function login (formData) {
  const response = await httpPost('/login', formData)
  return response.data
}

export async function register (formData) {
  const response = await httpPost('/register', formData)
  return response.data
}
export async function logout () {
  const response = await httpGet('/logout')
  return response.data
}

export async function getNews (filters) {
  const response = await httpGet('/news', { params: filters })
  return response.data
}

export async function getCategories () {
  const response = await httpGet('/categories')
  return response.data
}

export async function getArticle (articleId) {
  const response = await httpGet('/article/' + articleId)
  return response.data
}

export default {
  updateUserProfile,
  getUserProfile,
  logout,
  login,
  register,
  getNews,
  getCategories,
  getArticle
}
