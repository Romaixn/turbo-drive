import { defineConfig } from 'vite'
const { resolve } = require('path')

// https://vitejs.dev/config
export default defineConfig({
	build: {
		// output dir for production build
		outDir: resolve(__dirname, './dist'),
		emptyOutDir: true,

		// esbuild target
		target: 'es2018',

		// our entry
		rollupOptions: {
			input: {
				main: resolve( __dirname + '/assets/main.js')
			},

			output: {
				entryFileNames: `[name].js`,
				chunkFileNames: `[name].js`,
				assetFileNames: `[name].[ext]`
			}
		},

		// minifying switch
		minify: true,
		write: true
	},
})
