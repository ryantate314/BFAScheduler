class CreateWorkerPositions < ActiveRecord::Migration
  def change
    create_table :worker_positions do |t|
	t.belongs_to :EventWorkerPosition
	t.int :id
      t.string :name
      t.Boolean :requiresTraining

      t.timestamps null: false
    end
  end
end
