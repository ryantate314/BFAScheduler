class CreateEventWorkerPositions < ActiveRecord::Migration
  def change
    create_table :event_worker_positions do |t|
      t.int :estimatedHours

      t.timestamps null: false
    end
  end
end
